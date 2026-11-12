const assert = require('node:assert/strict');
const { chromium } = require('playwright');
module.exports = async function ({ base, origin }) {
  const browser = await chromium.launch({ headless: true, channel: 'msedge' });
  try {
    const page = await browser.newPage({ viewport: { width: 1440, height: 1000 } });
    const errors = [];
    page.on('pageerror', e => errors.push(e.message));
    await page.route('**/site-api/v1/admin/**', async route => {
      const url = new URL(route.request().url());
      const response = await route.fetch({ url: base + url.pathname + url.search });
      await route.fulfill({ response });
    });
    await page.goto(origin + '/admin');
    await page.getByRole('heading', { name: 'Entrar na administração' }).waitFor();
    await page.screenshot({ path: 'tmp/admin-login.png' });
    await page.getByLabel('E-mail', { exact: true }).fill('admin@example.com');
    await page.getByLabel('Senha', { exact: true }).fill('Test-password-2027!');
    await page.getByRole('button', { name: 'Entrar', exact: true }).click();
    await page.getByRole('heading', { name: 'Inscrições de staff' }).waitFor();
    await page.getByRole('button', { name: 'Ver inscrição de Staff Teste 25', exact: true }).waitFor();
    assert.equal(await page.locator('tbody tr').count(), 20);
    await page.screenshot({ path: 'tmp/admin-desktop.png' });
    await page.getByLabel('Buscar inscrição').fill('staff1@example.com');
    await page.getByRole('button', { name: 'Buscar', exact: true }).click();
    await page.getByRole('button', { name: 'Ver inscrição de Staff Teste 1', exact: true }).click();
    await page.getByRole('dialog').getByText('Quero fazer parte da equipe.', { exact: false }).waitFor();
    await page.waitForTimeout(350);
    assert.equal(await page.locator('script').filter({ hasText: 'alert(1)' }).count(), 0);
    await page.screenshot({ path: 'tmp/admin-detail.png' });
    await page.getByRole('button', { name: 'Fechar', exact: true }).click();
    await page.reload();
    await page.getByRole('heading', { name: 'Inscrições de staff' }).waitFor();
    await page.setViewportSize({ width: 390, height: 844 });
    await page.screenshot({ path: 'tmp/admin-mobile.png' });
    assert.equal(await page.evaluate(() => document.documentElement.scrollWidth > innerWidth), false);
    await page.getByRole('button', { name: 'Sair da conta' }).click();
    await page.getByRole('heading', { name: 'Entrar na administração' }).waitFor();
    assert.equal(await page.locator('tbody tr').count(), 0);
    assert.deepEqual(errors, []);
    console.log('Admin browser tests passed: login, table, search, escaped detail, session restore, mobile and logout.');
  } finally { await browser.close(); }
};
