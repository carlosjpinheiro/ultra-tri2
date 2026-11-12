import assert from 'node:assert/strict';
import { spawn, spawnSync } from 'node:child_process';
import { mkdtemp, rm } from 'node:fs/promises';
import { tmpdir } from 'node:os';
import { join, resolve } from 'node:path';
import { randomBytes } from 'node:crypto';
import { createServer } from 'node:net';
import { createRequire } from 'node:module';

const root = resolve(import.meta.dirname, '..');
const temporary = await mkdtemp(join(tmpdir(), 'ultra-admin-'));
const env = { ...process.env, SITE_ADMIN_TEST_DB: `us_admin_test_${randomBytes(8).toString('hex')}`, ULTRA_SITE_DB_CONFIG: join(temporary, 'db.php') };
const php = process.env.PHP_BINARY || 'php';
let server;
function fixture(action, extra = {}) {
  const result = spawnSync(php, ['tests/site-admin-fixture.php', action], { cwd: root, env: { ...env, ...extra }, encoding: 'utf8' });
  if (result.status !== 0) throw new Error(`Fixture ${action} failed: ${result.stderr}`);
}
const listener = createServer();
await new Promise(resolve => listener.listen(0, '127.0.0.1', resolve));
const port = listener.address().port;
await new Promise(resolve => listener.close(resolve));
const base = `http://127.0.0.1:${port}`;
let cookie = '';
let token = '';
async function request(path, { method = 'GET', body, csrf = token, authenticated = true } = {}) {
  const response = await fetch(`${base}/site-api/v1/admin/${path}`, { method, headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': csrf, ...(authenticated && cookie ? { Cookie: cookie } : {}) }, body: body === undefined ? undefined : JSON.stringify(body) });
  if (authenticated) for (const value of response.headers.getSetCookie()) cookie = value.split(';')[0];
  return { status: response.status, body: await response.json(), headers: response.headers };
}
async function login() {
  const session = await request('session');
  token = session.body.csrf_token;
  const result = await request('login', { method: 'POST', body: { email: 'admin@example.com', password: 'Test-password-2027!' } });
  assert.equal(result.status, 200);
  token = result.body.csrf_token;
  return result;
}
try {
  fixture('setup');
  server = spawn(php, ['-d', 'extension=mbstring', '-S', `127.0.0.1:${port}`, 'scripts/site-router.php'], { cwd: root, env, stdio: 'ignore' });
  let ready = false;
  for (let i = 0; i < 60; i++) {
    try { if ((await fetch(`${base}/site-api/v1/health`)).ok) { ready = true; break; } } catch {}
    await new Promise(resolve => setTimeout(resolve, 100));
  }
  assert.ok(ready, 'PHP server started');
  assert.equal((await request('staff', { authenticated: false })).status, 401);
  assert.equal((await request('staff/1', { authenticated: false })).status, 401);
  const session = await request('session');
  assert.equal(session.body.user, null);
  assert.match(session.headers.get('set-cookie'), /HttpOnly/i);
  assert.match(session.headers.get('set-cookie'), /SameSite=Strict/i);
  token = session.body.csrf_token;
  assert.equal((await request('login', { method: 'POST', csrf: 'invalid', body: { email: 'admin@example.com', password: 'Test-password-2027!' } })).status, 403);
  assert.equal((await request('login', { method: 'POST', body: { email: 'admin@example.com', password: 'wrong' } })).status, 401);
  const oldCookie = cookie;
  await login();
  assert.notEqual(cookie, oldCookie, 'Session ID rotates at login');
  const list = await request('staff');
  assert.equal(list.status, 200);
  assert.equal(list.body.total, 25);
  assert.equal(list.body.items.length, 20);
  assert.match(list.headers.get('cache-control'), /no-store/);
  assert.ok(!('answers' in list.body.items[0]));
  assert.equal((await request('staff?page=2')).body.items.length, 5);
  const found = await request('staff?search=staff1%40example.com');
  assert.equal(found.body.total, 1);
  assert.equal((await request('staff?search=' + encodeURIComponent("' OR 1=1 --"))).body.total, 0);
  assert.equal((await request('staff/1')).body.registration.answers.nome, 'Staff Teste 1');
  assert.equal((await request('staff/9999')).status, 404);
  assert.equal((await request('logout', { method: 'POST', csrf: 'invalid', body: {} })).status, 403);
  fixture('restrict');
  assert.equal((await request('staff')).status, 403, 'Role revocation affects existing session');
  fixture('enable');
  fixture('disable');
  assert.equal((await request('staff/1')).status, 401, 'Disabled account cannot read detail');
  fixture('enable');
  await login();
  fixture('expire', { SITE_ADMIN_TEST_SESSION: cookie.split('=')[1] });
  assert.equal((await request('staff')).status, 401, 'Idle expiry enforced');
  await login();
  assert.equal((await request('logout', { method: 'POST', body: {} })).status, 200);
  assert.equal((await request('staff')).status, 401, 'Logout blocks subsequent access');
  console.log('Admin HTTP tests passed: authentication, CSRF, session rotation/expiry/logout, authorization, revocation, pagination, search and detail.');
  if (process.env.ULTRA_SITE_UI_ORIGIN) {
    const require = createRequire(import.meta.url);
    await require('./site-admin-browser.cjs')({ base, origin: process.env.ULTRA_SITE_UI_ORIGIN });
  }
  const session2 = await request('session'); token = session2.body.csrf_token;
  let blocked = false;
  for (let i = 0; i < 12; i++) {
    const result = await request('login', { method: 'POST', body: { email: 'admin@example.com', password: 'wrong' } });
    if (result.status === 429) { blocked = true; break; }
  }
  assert.ok(blocked, 'Repeated login attempts blocked');
  console.log('Login rate limiting passed.');
} finally {
  if (server && server.exitCode === null) {
    await new Promise(resolve => { server.once('exit', resolve); server.kill(); });
  }
  try { fixture('drop'); } finally { await rm(temporary, { recursive: true, force: true }); }
}
