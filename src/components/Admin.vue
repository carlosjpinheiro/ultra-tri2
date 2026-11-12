<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';
import fields from '../../site-api/schema/staff.json';
const user = ref(null);
const csrf = ref('');
const booting = ref(true);
const busy = ref(false);
const loading = ref(false);
const error = ref('');
const detailError = ref('');
const email = ref('');
const password = ref('');
const search = ref('');
const appliedSearch = ref('');
const items = ref([]);
const total = ref(0);
const page = ref(1);
const pages = computed(() => Math.max(1, Math.ceil(total.value / 20)));
const selected = ref(null);
const detailOpen = ref(false);
const detailLoading = ref(false);
let listRequest = 0;
let detailRequest = 0;
let controller = new AbortController();
function clearPrivateData() {
  user.value = null;
  items.value = [];
  total.value = 0;
  selected.value = null;
  detailOpen.value = false;
  detailError.value = '';
  ++listRequest;
  ++detailRequest;
}
async function api(path, options = {}) {
  const response = await fetch(`/site-api/v1/admin/${path}`, {
    credentials: 'same-origin', cache: 'no-store', signal: controller.signal,
    ...options,
    headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': csrf.value, ...options.headers },
  });
  let data;
  try { data = await response.json(); }
  catch { throw new Error('Não foi possível acessar a administração. Verifique a conexão e tente novamente.'); }
  if (!response.ok) {
    if (response.status === 401 || response.status === 403) clearPrivateData();
    throw new Error(data.message || 'Não foi possível concluir a solicitação.');
  }
  return data;
}
async function loadSession() {
  const session = await api('session');
  csrf.value = session.csrf_token;
  user.value = session.user;
}
async function login() {
  if (busy.value) return;
  busy.value = true;
  error.value = '';
  try {
    await loadSession();
    const session = await api('login', { method: 'POST', body: JSON.stringify({ email: email.value.trim(), password: password.value }) });
    user.value = session.user;
    csrf.value = session.csrf_token;
    password.value = '';
    await loadStaff(1);
  } catch (e) { error.value = e.message; }
  finally { busy.value = false; }
}
async function logout() {
  busy.value = true;
  error.value = '';
  try {
    await api('logout', { method: 'POST', body: '{}' });
    clearPrivateData();
    password.value = '';
    search.value = '';
    appliedSearch.value = '';
    await loadSession();
  } catch (e) { error.value = e.message; }
  finally { busy.value = false; }
}
async function loadStaff(nextPage = page.value) {
  const request = ++listRequest;
  loading.value = true;
  error.value = '';
  selected.value = null;
  try {
    const result = await api(`staff?page=${nextPage}&search=${encodeURIComponent(appliedSearch.value)}`);
    if (request !== listRequest || !user.value) return;
    items.value = result.items;
    total.value = result.total;
    page.value = result.page;
  } catch (e) { if (e.name !== 'AbortError') error.value = e.message; }
  finally { if (request === listRequest || !user.value) loading.value = false; }
}
function applySearch() { appliedSearch.value = search.value; loadStaff(1); }
async function showDetail(id) {
  const request = ++detailRequest;
  selected.value = null;
  detailError.value = '';
  detailOpen.value = true;
  detailLoading.value = true;
  try {
    const result = await api(`staff/${id}`);
    if (request === detailRequest && user.value && detailOpen.value) selected.value = result.registration;
  } catch (e) { if (e.name !== 'AbortError') detailError.value = e.message; }
  finally { if (request === detailRequest || !user.value) detailLoading.value = false; }
}
const answerText = value => Array.isArray(value) ? value.join('\n') : typeof value === 'boolean' ? (value ? 'Sim' : 'Não') : value || 'Não informado';
const formatDate = value => {
  if (!value) return '—';
  const match = value.match(/^(\d{4})-(\d{2})-(\d{2})/);
  return match ? `${match[3]}/${match[2]}/${match[1]}` : value;
};
onMounted(async () => {
  try { await loadSession(); if (user.value) await loadStaff(1); }
  catch (e) { error.value = e.message; }
  finally { booting.value = false; }
});
onUnmounted(() => { controller.abort(); clearPrivateData(); password.value = ''; });
</script>

<template>
  <div class="admin-root">
    <div v-if="booting" class="admin-loading" role="status">Carregando administração…</div>
    <main v-else-if="!user" class="admin-login">
      <div class="admin-login-intro"><RouterLink to="/" class="admin-brand">BRASIL <strong>ULTRA TRI</strong></RouterLink><p>ADMINISTRAÇÃO DO SITE</p><h1>Quem faz o Ultra acontecer.</h1><p>Acesse as inscrições e acompanhe a equipe do evento.</p></div>
      <section class="admin-login-card" aria-labelledby="login-title">
        <p class="admin-eyebrow">ÁREA RESTRITA</p><h2 id="login-title">Entrar na administração</h2><p>Use o e-mail e a senha da sua conta de administrador.</p>
        <div v-if="error" class="admin-error" role="alert">{{ error }}</div>
        <form @submit.prevent="login">
          <label for="admin-email">E-mail</label><input id="admin-email" v-model="email" type="email" maxlength="190" autocomplete="username" required :disabled="busy">
          <label for="admin-password">Senha</label><input id="admin-password" v-model="password" type="password" maxlength="1024" autocomplete="current-password" required :disabled="busy">
          <button class="admin-button" :disabled="busy">{{ busy ? 'Entrando…' : 'Entrar' }}</button>
        </form>
        <RouterLink to="/" class="admin-back">← Voltar ao site</RouterLink>
      </section>
    </main>
    <div v-else class="admin-shell">
      <aside class="admin-sidebar">
        <RouterLink to="/" class="admin-brand">BRASIL <strong>ULTRA TRI</strong></RouterLink>
        <p class="admin-sidebar-label">ADMINISTRAÇÃO</p>
        <nav aria-label="Menu administrativo"><RouterLink to="/admin" class="admin-nav-item" aria-current="page"><span aria-hidden="true">▤</span> Inscrições de staff</RouterLink></nav>
        <div class="admin-sidebar-footer"><span>{{ user.name }}</span><small>{{ user.email }}</small><button type="button" @click="logout" :disabled="busy">{{ busy ? 'Saindo…' : 'Sair da conta' }}</button><RouterLink to="/">Voltar ao site ↗</RouterLink></div>
      </aside>
      <main class="admin-content">
        <header class="admin-heading"><div><p class="admin-eyebrow">EQUIPE · BRASIL ULTRA TRI</p><h1>Inscrições de staff</h1><p>Acompanhe as candidaturas e conheça quem quer fazer parte da equipe.</p></div><button type="button" class="admin-button admin-button-secondary" @click="loadStaff()" :disabled="loading">Atualizar</button></header>
        <div v-if="error" class="admin-error" role="alert">{{ error }}</div>
        <section class="admin-stat"><span>{{ total }}</span><div>{{ appliedSearch ? 'Inscrições encontradas' : 'Inscrições recebidas' }}<small>Staff Brasil Ultra Tri</small></div></section>
        <section class="admin-panel" aria-label="Inscrições de staff">
          <form class="admin-toolbar" @submit.prevent="applySearch"><div><label for="staff-search">Buscar inscrição</label><input id="staff-search" v-model="search" type="search" maxlength="180" placeholder="Nome ou e-mail"></div><button class="admin-button" :disabled="loading">Buscar</button></form>
          <p v-if="loading" class="admin-table-message" role="status">Carregando inscrições…</p>
          <p v-else-if="!items.length" class="admin-table-message">{{ appliedSearch ? 'Nenhuma inscrição encontrada para esta busca.' : 'Ainda não há inscrições de staff.' }}</p>
          <div v-else class="admin-table-wrap"><table><caption class="admin-sr-only">Inscrições de staff, mais recentes primeiro</caption><thead><tr><th scope="col">Nome / E-mail</th><th scope="col">WhatsApp</th><th scope="col">Cidade / Estado</th><th scope="col">Departamentos</th><th scope="col">Inscrição</th><th scope="col">Ações</th></tr></thead><tbody><tr v-for="staff in items" :key="staff.id"><td><strong>{{ staff.name }}</strong><small>{{ staff.email }}</small></td><td>{{ staff.whatsapp || '—' }}</td><td>{{ staff.city || '—' }}</td><td><span v-for="department in staff.departments" :key="department" class="admin-tag">{{ department }}</span></td><td>{{ formatDate(staff.created_at) }}<small>Edição {{ staff.event_year }}</small></td><td><button type="button" class="admin-detail-button" :aria-label="`Ver inscrição de ${staff.name}`" @click="showDetail(staff.id)">Ver inscrição →</button></td></tr></tbody></table></div>
          <footer class="admin-pagination"><span>Página {{ page }} de {{ pages }} · {{ total }} registros</span><div><button type="button" @click="loadStaff(page - 1)" :disabled="loading || page <= 1">Anterior</button><button type="button" @click="loadStaff(page + 1)" :disabled="loading || page >= pages">Próxima</button></div></footer>
        </section>
      </main>
      <VDialog v-model="detailOpen" max-width="800" aria-labelledby="admin-detail-title" scrollable>
        <VCard class="admin-detail-card"><VCardTitle id="admin-detail-title" class="text-wrap">{{ selected?.name || 'Inscrição de staff' }}</VCardTitle><VCardText>
          <p v-if="detailLoading" role="status">Carregando respostas…</p><div v-if="detailError" class="admin-error" role="alert">{{ detailError }}</div>
          <template v-if="selected"><p>Recebida em {{ formatDate(selected.created_at) }} · Edição {{ selected.event_year }}</p><dl class="admin-answers"><template v-for="field in fields" :key="field.key"><template v-if="Object.hasOwn(selected.answers, field.key)"><dt>{{ field.label }}</dt><dd>{{ field.type === 'date' ? formatDate(selected.answers[field.key]) : answerText(selected.answers[field.key]) }}</dd></template></template></dl></template>
        </VCardText><VCardActions><VBtn @click="detailOpen = false">Fechar</VBtn></VCardActions></VCard>
      </VDialog>
    </div>
  </div>
</template>

<style scoped>
.admin-root { min-height: 100vh; background: #f3f5f4; color: #19372d; font-family: inherit; }
.admin-root button, .admin-root input { font: inherit; }
.admin-loading { padding: 80px 24px; text-align: center; }
.admin-login { min-height: 100vh; display: grid; grid-template-columns: 1fr 1fr; }
.admin-login-intro { background: #123e2e; color: #fff; display: flex; flex-direction: column; justify-content: center; padding: clamp(32px, 7vw, 110px); }
.admin-brand { color: #fff !important; text-decoration: none; font-size: 15px; letter-spacing: 2px; line-height: 1.4; display: flex; flex-direction: column; width: fit-content; }
.admin-brand strong { font-size: 26px; letter-spacing: 1px; color: #fcb603; }
.admin-login-intro > p:first-of-type { margin-top: 64px; font-size: 12px; letter-spacing: 2px; color: #d7e3dc; }
.admin-login-intro h1 { font-size: clamp(32px, 4vw, 56px); color: #fff; margin: 18px 0 24px; letter-spacing: -1.5px; }
.admin-login-intro p { line-height: 1.8; max-width: 400px; color: #d7e3dc; }
.admin-login-card { align-self: center; width: min(440px, calc(100% - 48px)); margin: 48px auto; }
.admin-eyebrow { font-size: 11px; font-weight: 800; letter-spacing: 1.8px; color: #55816b; margin: 0 0 12px; }
.admin-login-card h2 { font-size: 30px; margin-bottom: 12px; }
.admin-login-card > p:not(.admin-eyebrow) { color: #68776f; line-height: 1.7; }
.admin-login-card form { margin-top: 32px; }
.admin-root label { font-weight: 700; font-size: 13px; display: block; margin-bottom: 8px; }
.admin-root input { width: 100%; min-width: 0; padding: 12px 14px; background: #fff; border: 1px solid #cdd8d1; border-radius: 8px; color: #19372d; }
.admin-root input:focus { outline: 2px solid #328658; outline-offset: 2px; }
.admin-login-card input { margin-bottom: 24px; }
.admin-button { background: #176c43; color: #fff; padding: 12px 20px; border-radius: 8px; font-weight: 700 !important; border: 1px solid transparent; cursor: pointer; white-space: nowrap; }
.admin-login-card .admin-button { width: 100%; }
.admin-root button:disabled { opacity: .5; cursor: default; }
.admin-back { display: inline-block; margin-top: 24px; color: #365f4b; font-size: 14px; }
.admin-error { background: #fff0ee; border: 1px solid #e7b4ac; color: #8e2f26; border-radius: 8px; padding: 14px 18px; margin: 20px 0; }
.admin-shell { display: grid; grid-template-columns: 248px minmax(0, 1fr); min-height: 100vh; }
.admin-sidebar { background: #123e2e; color: white; padding: 32px 20px 24px; display: flex; flex-direction: column; gap: 24px; }
.admin-sidebar { position: sticky; top: 0; height: 100dvh; align-self: start; overflow-y: auto; }
.admin-sidebar-label { font-size: 10px; letter-spacing: 2px; color: #a4c3b1; margin: 24px 12px 0; }
.admin-nav-item { display: flex; gap: 12px; align-items: center; background: #ffffff15; color: #fff !important; padding: 14px 12px; border-radius: 8px; font-size: 14px; text-decoration: none; border-left: 3px solid #fcb603; }
.admin-sidebar-footer { margin-top: auto; padding-top: 48px; display: flex; flex-direction: column; gap: 8px; overflow-wrap: anywhere; font-size: 14px; }
.admin-sidebar-footer small { color: #b8d0c2; }
.admin-sidebar-footer button { text-align: left; color: #fff; background: #ffffff12; border: 1px solid #ffffff30; padding: 10px; border-radius: 6px; margin-top: 12px; }
.admin-sidebar-footer a { color: #b8d0c2; font-size: 12px; margin-top: 8px; }
.admin-content { padding: clamp(24px, 4vw, 56px); min-width: 0; }
.admin-heading { display: flex; align-items: center; justify-content: space-between; gap: 24px; margin-bottom: 32px; }
.admin-heading h1 { font-size: clamp(28px, 3vw, 38px); margin: 0 0 10px; letter-spacing: -1px; }
.admin-heading p:last-child { color: #68776f; font-size: 14px; line-height: 1.7; margin: 0; }
.admin-button-secondary { background: #fff; color: #24563d; border-color: #cdd8d1; }
.admin-stat { border: 1px solid #dce4de; border-radius: 12px; padding: 24px; background: #fff; display: flex; gap: 20px; align-items: center; margin-bottom: 24px; width: fit-content; min-width: 260px; }
.admin-stat > span { font-size: 38px; font-weight: 800; }
.admin-stat div { font-weight: 600; font-size: 14px; }
.admin-stat small { display: block; color: #7b8981; font-size: 12px; margin-top: 4px; }
.admin-panel { border: 1px solid #dce4de; border-radius: 12px; background: white; overflow: hidden; }
.admin-toolbar { display: flex; align-items: flex-end; gap: 12px; padding: 24px; border-bottom: 1px solid #e7ece8; }
.admin-toolbar > div { width: min(440px, 100%); }
.admin-table-wrap { overflow-x: auto; }
table { border-collapse: collapse; width: 100%; font-size: 13px; text-align: left; }
th { background: #f8faf8; color: #68776f; font-weight: 700; white-space: nowrap; }
th, td { padding: 18px; border-bottom: 1px solid #edf1ee; vertical-align: top; }
td strong { display: block; font-size: 14px; min-width: 140px; }
td small { display: block; color: #7b8981; margin-top: 6px; }
.admin-tag { display: block; background: #eff5ef; color: #376548; border-radius: 5px; padding: 4px 7px; margin-bottom: 5px; font-size: 11px; min-width: 120px; }
.admin-detail-button { color: #176c43; font-weight: 700; white-space: nowrap; background: none; border: 0; }
.admin-table-message { text-align: center; color: #68776f; padding: 56px 20px; margin: 0; }
.admin-pagination { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 16px; align-items: center; padding: 20px 24px; color: #68776f; font-size: 12px; }
.admin-pagination div { display: flex; gap: 8px; }
.admin-pagination button { background: white; border: 1px solid #dce4de; border-radius: 6px; padding: 8px 12px; color: #19372d; }
.admin-detail-card { color: #19372d; }
.admin-answers dt { font-weight: 700; font-size: 14px; margin-top: 24px; }
.admin-answers dd { margin: 8px 0 0; padding-bottom: 18px; border-bottom: 1px solid #edf1ee; white-space: pre-wrap; overflow-wrap: anywhere; font-size: 14px; line-height: 1.8; }
.admin-sr-only { position: absolute; width: 1px; height: 1px; overflow: hidden; clip-path: inset(50%); }
@media(max-width: 850px) { .admin-shell { grid-template-columns: 1fr; } .admin-sidebar { padding: 20px; gap: 16px; } .admin-sidebar-label { display: none; } .admin-sidebar-footer { padding: 0; flex-direction: row; flex-wrap: wrap; align-items: center; gap: 12px; } .admin-sidebar-footer small { display: none; } .admin-sidebar-footer button, .admin-sidebar-footer a { margin-top: 0; } .admin-login { grid-template-columns: 1fr; } .admin-login-intro { padding: 32px 24px; } .admin-login-intro > p:first-of-type { margin-top: 24px; } .admin-login-intro h1 { font-size: 32px; } .admin-login-intro > p:last-child { display: none; } }
@media(max-width: 520px) { .admin-heading { align-items: flex-start; flex-direction: column; } .admin-content { padding: 24px 16px; } .admin-toolbar { padding: 18px; } .admin-toolbar .admin-button { padding-inline: 14px; } .admin-stat { width: 100%; min-width: 0; } }
@media(max-width: 850px) { .admin-sidebar { position: static; height: auto; } }
</style>
