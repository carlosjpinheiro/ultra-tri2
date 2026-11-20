<script setup>
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import staffFields from '../../site-api/schema/staff.json';
import athleteFields from '../../site-api/schema/athlete.json';
import MessageDialog from './MessageDialog.vue';
const route = useRoute();
const athletes = computed(() => route.query.section === 'athletes');
const resource = computed(() => athletes.value ? 'athletes' : 'staff');
const title = computed(() => athletes.value ? 'Inscrições de atletas' : 'Inscrições de staff');
const fields = computed(() => athletes.value ? athleteFields : staffFields);
const user = ref(null);
const csrf = ref('');
const booting = ref(true);
const busy = ref(false);
const loading = ref(false);
const error = ref('');
const errorDialogOpen = computed({
  get: () => Boolean(error.value),
  set: value => { if (!value) error.value = ''; },
});
const email = ref('');
const password = ref('');
const search = ref('');
const appliedSearch = ref('');
const modality = ref('');
const modalities = ref([]);
const direction = ref('desc');
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
  modality.value = '';
  modalities.value = [];
  selected.value = null;
  detailOpen.value = false;
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
    await loadRegistrations(1);
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
async function loadRegistrations(nextPage = page.value) {
  const request = ++listRequest;
  loading.value = true;
  error.value = '';
  selected.value = null;
  try {
    const parameters = new URLSearchParams({
      page: String(nextPage), search: appliedSearch.value, direction: direction.value,
    });
    if (athletes.value) parameters.set('modality', modality.value);
    const result = await api(`${resource.value}?${parameters}`);
    if (request !== listRequest || !user.value) return;
    items.value = result.items;
    total.value = result.total;
    page.value = result.page;
    modalities.value = result.modalities || [];
  } catch (e) { if (e.name !== 'AbortError') error.value = e.message; }
  finally { if (request === listRequest || !user.value) loading.value = false; }
}
function applySearch() { appliedSearch.value = search.value; loadRegistrations(1); }
function toggleDateSort() {
  direction.value = direction.value === 'desc' ? 'asc' : 'desc';
  loadRegistrations(1);
}
async function showDetail(id) {
  const request = ++detailRequest;
  selected.value = null;
  detailOpen.value = true;
  detailLoading.value = true;
  try {
    const result = await api(`${resource.value}/${id}`);
    if (request === detailRequest && user.value && detailOpen.value) selected.value = result.registration;
  } catch (e) {
    if (e.name !== 'AbortError') {
      detailOpen.value = false;
      error.value = e.message;
    }
  }
  finally { if (request === detailRequest || !user.value) detailLoading.value = false; }
}
const answerText = value => Array.isArray(value) ? value.join('\n') : typeof value === 'boolean' ? (value ? 'Sim' : 'Não') : value || 'Não informado';
const formatDate = value => {
  if (!value) return '—';
  const match = value.match(/^(\d{4})-(\d{2})-(\d{2})/);
  return match ? `${match[3]}/${match[2]}/${match[1]}` : value;
};
const formatRegistrationDate = value => value
  ? `${formatDate(value)} ${value.slice(11, 16)}`.trim()
  : '—';
onMounted(async () => {
  try { await loadSession(); if (user.value) await loadRegistrations(1); }
  catch (e) { error.value = e.message; }
  finally { booting.value = false; }
});
onUnmounted(() => { controller.abort(); clearPrivateData(); password.value = ''; });
watch(resource, () => {
  ++listRequest;
  ++detailRequest;
  items.value = [];
  total.value = 0;
  page.value = 1;
  search.value = '';
  appliedSearch.value = '';
  modality.value = '';
  modalities.value = [];
  direction.value = 'desc';
  selected.value = null;
  detailOpen.value = false;
  if (user.value) loadRegistrations(1);
});
</script>

<template>
  <div class="admin-root">
    <MessageDialog v-model="errorDialogOpen" title="Não foi possível concluir" :message="error" type="error" />
    <div v-if="booting" class="admin-loading" role="status">Carregando administração…</div>
    <main v-else-if="!user" class="admin-login">
      <div class="admin-login-intro"><RouterLink to="/" class="admin-brand">BRASIL <strong>ULTRA TRI</strong></RouterLink><p>ADMINISTRAÇÃO DO SITE</p><h1>Quem faz o Ultra acontecer.</h1><p>Acesse as inscrições e acompanhe a equipe do evento.</p></div>
      <section class="admin-login-card" aria-labelledby="login-title">
        <p class="admin-eyebrow">ÁREA RESTRITA</p><h2 id="login-title">Entrar na administração</h2><p>Use o e-mail e a senha da sua conta de administrador.</p>
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
        <nav aria-label="Menu administrativo"><RouterLink to="/admin" class="admin-nav-item" :class="{ 'admin-nav-selected': !athletes }" :aria-current="!athletes ? 'page' : undefined"><span aria-hidden="true">▤</span> Inscrições de staff</RouterLink><RouterLink :to="{ path: '/admin', query: { section: 'athletes' } }" class="admin-nav-item" :class="{ 'admin-nav-selected': athletes }" :aria-current="athletes ? 'page' : undefined"><span aria-hidden="true">▤</span> Inscrições de atletas</RouterLink></nav>
        <div class="admin-sidebar-footer"><span>{{ user.name }}</span><small>{{ user.email }}</small><button type="button" @click="logout" :disabled="busy">{{ busy ? 'Saindo…' : 'Sair da conta' }}</button><RouterLink to="/">Voltar ao site ↗</RouterLink></div>
      </aside>
      <main class="admin-content">
        <header class="admin-heading">
          <div class="admin-heading-copy">
            <p class="admin-eyebrow">EQUIPE · BRASIL ULTRA TRI</p>
            <h1>{{ title }}</h1><!-- <p>{{ athletes ? 'Consulte os atletas pré-inscritos e os dados enviados pelo site.' : 'Acompanhe as candidaturas e conheça quem quer fazer parte da equipe.' }}</p> -->
          </div>
          <section class="admin-stat" aria-label="Total de inscrições">
            <span>{{ total }}</span>
            <div>{{ appliedSearch || modality ? 'Inscrições encontradas' : 'Inscrições recebidas' }}<small>{{ athletes ? 'Atletas' : 'Staff Brasil Ultra Tri' }}</small></div>
          </section>
        </header>
        <section class="admin-panel" :aria-label="title">
          <form class="admin-toolbar" @submit.prevent="applySearch">
            <div class="admin-search">
              <label for="registration-search">Buscar inscrição</label>
              <input id="registration-search" v-model="search" type="search" maxlength="180" placeholder="Nome ou e-mail">
            </div>
            <div v-if="athletes" class="admin-modality-filter">
              <label for="registration-modality">Modalidade</label>
              <select id="registration-modality" v-model="modality" :disabled="loading" @change="applySearch">
                <option value="">Todas as modalidades</option>
                <option v-for="option in modalities" :key="option" :value="option">{{ option }}</option>
              </select>
            </div>
            <button class="admin-button" :disabled="loading">Buscar</button>
            <button type="button" class="admin-button admin-button-secondary" @click="loadRegistrations()" :disabled="loading">Atualizar</button>
          </form>
          <p v-if="loading" class="admin-table-message" role="status">Carregando inscrições…</p>
          <p v-else-if="!items.length" class="admin-table-message">{{ appliedSearch ? 'Nenhuma inscrição encontrada para esta busca.' : 'Ainda não há inscrições recebidas.' }}</p>
          <div v-else class="admin-table-wrap" tabindex="0" role="region" :aria-label="title">
            <table>
              <caption class="admin-sr-only">{{ title }}, {{ direction === 'desc' ? 'mais recentes primeiro' : 'mais antigas primeiro' }}</caption>
              <thead>
                <tr>
                  <th scope="col">Nome</th>
                  <th scope="col">E-mail</th>
                  <th scope="col">{{ athletes ? 'Telefone' : 'WhatsApp' }}</th>
                  <th v-if="!athletes" scope="col">Cidade / Estado</th>
                  <th scope="col">{{ athletes ? 'Modalidade' : 'Departamentos' }}</th>
                  <th scope="col">{{ athletes ? 'Evento' : 'Edição' }}</th>
                  <th scope="col" :aria-sort="direction === 'desc' ? 'descending' : 'ascending'">
                    <button type="button" class="admin-sort-button" :disabled="loading" @click="toggleDateSort">
                      Data de inscrição <span aria-hidden="true">{{ direction === 'desc' ? '↓' : '↑' }}</span>
                    </button>
                  </th>
                  <th scope="col">Ações</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="registration in items" :key="registration.id">
                  <td class="admin-registration-name">{{ registration.name }}</td>
                  <td>{{ registration.email }}</td>
                  <td>{{ (athletes ? registration.phone : registration.whatsapp) || '—' }}</td>
                  <td v-if="!athletes">{{ registration.city || '—' }}</td>
                  <td>{{ athletes ? registration.modality : (registration.departments || []).join(', ') || '—' }}</td>
                  <td>{{ athletes ? registration.event_code : registration.event_year }}</td>
                  <td>{{ formatRegistrationDate(registration.created_at) }}</td>
                  <td>
                    <button type="button" class="admin-detail-button" :aria-label="`Ver inscrição de ${registration.name}`" @click="showDetail(registration.id)">Ver inscrição →</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <footer class="admin-pagination"><span>Página {{ page }} de {{ pages }} · {{ total }} registros</span><div><button type="button" @click="loadRegistrations(page - 1)" :disabled="loading || page <= 1">Anterior</button><button type="button" @click="loadRegistrations(page + 1)" :disabled="loading || page >= pages">Próxima</button></div></footer>
        </section>
      </main>
      <VDialog v-model="detailOpen" max-width="800" aria-labelledby="admin-detail-title" scrollable>
        <VCard class="admin-detail-card"><VCardTitle id="admin-detail-title" class="text-wrap">{{ selected?.name || 'Detalhes da inscrição' }}</VCardTitle><VCardText>
          <p v-if="detailLoading" role="status">Carregando respostas…</p>
          <template v-if="selected"><p>Recebida em {{ formatDate(selected.created_at) }} · {{ athletes ? selected.event_code : 'Edição ' + selected.event_year }}</p><dl class="admin-answers"><template v-for="field in fields" :key="field.key"><template v-if="Object.hasOwn(selected.answers, field.key)"><dt>{{ field.label }}</dt><dd>{{ field.type === 'date' ? formatDate(selected.answers[field.key]) : answerText(selected.answers[field.key]) }}</dd></template></template></dl></template>
        </VCardText><VCardActions><VBtn @click="detailOpen = false">Fechar</VBtn></VCardActions></VCard>
      </VDialog>
    </div>
  </div>
</template>

<style scoped>
.admin-root { min-height: 100vh; background: #f3f5f4; color: #19372d; font-family: inherit; }
.admin-root button, .admin-root input, .admin-root select { font: inherit; }
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
.admin-root input, .admin-root select { width: 100%; min-width: 0; padding: 12px 14px; background: #fff; border: 1px solid #cdd8d1; border-radius: 8px; color: #19372d; }
.admin-root input:focus, .admin-root select:focus { outline: 2px solid #328658; outline-offset: 2px; }
.admin-login-card input { margin-bottom: 24px; }
.admin-button { background: #176c43; color: #fff; padding: 12px 20px; border-radius: 8px; font-weight: 700 !important; border: 1px solid transparent; cursor: pointer; white-space: nowrap; }
.admin-login-card .admin-button { width: 100%; }
.admin-root button:disabled { opacity: .5; cursor: default; }
.admin-back { display: inline-block; margin-top: 24px; color: #365f4b; font-size: 14px; }
.admin-shell { display: grid; grid-template-columns: 248px minmax(0, 1fr); min-height: 100vh; }
.admin-sidebar { background: #123e2e; color: white; padding: 32px 20px 24px; display: flex; flex-direction: column; gap: 24px; }
.admin-sidebar { position: sticky; top: 0; height: 100dvh; align-self: start; overflow-y: auto; }
.admin-sidebar-label { font-size: 10px; letter-spacing: 2px; color: #a4c3b1; margin: 24px 12px 0; }
.admin-nav-item { display: flex; gap: 12px; align-items: center; background: transparent; color: #fff !important; padding: 14px 12px; border-radius: 8px; font-size: 14px; text-decoration: none; border-left: 3px solid transparent; }
.admin-sidebar-footer { margin-top: auto; padding-top: 48px; display: flex; flex-direction: column; gap: 8px; overflow-wrap: anywhere; font-size: 14px; }
.admin-sidebar-footer small { color: #b8d0c2; }
.admin-sidebar-footer button { text-align: left; color: #fff; background: #ffffff12; border: 1px solid #ffffff30; padding: 10px; border-radius: 6px; margin-top: 12px; }
.admin-sidebar-footer a { color: #b8d0c2; font-size: 12px; margin-top: 8px; }
.admin-content { padding: 32px clamp(20px, 3vw, 40px); min-width: 0; }
.admin-heading { display: flex; align-items: flex-start; justify-content: space-between; gap: 24px; margin-bottom: 24px; }
.admin-heading-copy { flex: 1; min-width: 0; }
.admin-heading h1 { font-size: clamp(28px, 3vw, 38px); margin: 0 0 10px; letter-spacing: -1px; }
.admin-heading p:last-child { color: #68776f; font-size: 14px; line-height: 1.7; margin: 0; }
.admin-button-secondary { background: #fff; color: #24563d; border-color: #cdd8d1; }
.admin-stat { border: 1px solid #dce4de; border-radius: 12px; padding: 16px 20px; background: #fff; display: flex; gap: 16px; align-items: center; flex-shrink: 0; min-width: 220px; }
.admin-stat > span { font-size: 38px; font-weight: 800; }
.admin-stat div { font-weight: 600; font-size: 14px; }
.admin-stat small { display: block; color: #7b8981; font-size: 12px; margin-top: 4px; }
.admin-panel { border: 1px solid #dce4de; border-radius: 12px; background: white; overflow: hidden; }
.admin-toolbar { display: flex; flex-wrap: wrap; align-items: flex-end; gap: 12px; padding: 18px 20px; border-bottom: 1px solid #e7ece8; }
.admin-search { flex: 1 1 220px; }
.admin-modality-filter { flex: 0 1 240px; min-width: 180px; }
.admin-table-wrap { overflow-x: auto; }
table { border-collapse: collapse; width: 100%; font-size: 13px; text-align: left; }
th { background: #f8faf8; color: #68776f; font-weight: 700; white-space: nowrap; }
th, td { padding: 10px 12px; border-bottom: 1px solid #edf1ee; vertical-align: middle; white-space: nowrap; line-height: 1.5; }
.admin-registration-name { font-weight: 700; }
.admin-sort-button { display: inline-flex; gap: 8px; align-items: center; color: inherit; background: none; border: 0; font-weight: inherit; }
.admin-detail-button { color: #176c43; font-weight: 700; white-space: nowrap; background: none; border: 0; }
.admin-table-message { text-align: center; color: #68776f; padding: 56px 20px; margin: 0; }
.admin-pagination { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 16px; align-items: center; padding: 14px 20px; color: #68776f; font-size: 12px; }
.admin-pagination div { display: flex; gap: 8px; }
.admin-pagination button { background: white; border: 1px solid #dce4de; border-radius: 6px; padding: 8px 12px; color: #19372d; }
.admin-detail-card { color: #19372d; }
.admin-answers dt { font-weight: 700; font-size: 14px; margin-top: 24px; }
.admin-answers dd { margin: 8px 0 0; padding-bottom: 18px; border-bottom: 1px solid #edf1ee; white-space: pre-wrap; overflow-wrap: anywhere; font-size: 14px; line-height: 1.8; }
.admin-sr-only { position: absolute; width: 1px; height: 1px; overflow: hidden; clip-path: inset(50%); }
@media(max-width: 850px) { .admin-shell { grid-template-columns: 1fr; } .admin-sidebar { padding: 20px; gap: 16px; } .admin-sidebar-label { display: none; } .admin-sidebar-footer { padding: 0; flex-direction: row; flex-wrap: wrap; align-items: center; gap: 12px; } .admin-sidebar-footer small { display: none; } .admin-sidebar-footer button, .admin-sidebar-footer a { margin-top: 0; } .admin-login { grid-template-columns: 1fr; } .admin-login-intro { padding: 32px 24px; } .admin-login-intro > p:first-of-type { margin-top: 24px; } .admin-login-intro h1 { font-size: 32px; } .admin-login-intro > p:last-child { display: none; } }
@media(max-width: 520px) { .admin-heading { align-items: flex-start; flex-direction: column; } .admin-content { padding: 24px 16px; } .admin-toolbar { padding: 18px; } .admin-toolbar .admin-button { padding-inline: 14px; } .admin-stat { width: 100%; min-width: 0; } }
@media(max-width: 850px) { .admin-sidebar { position: static; height: auto; } }
.admin-nav-item + .admin-nav-item { margin-top: 8px; }
.admin-nav-selected { background: #ffffff15; border-left-color: #fcb603; }
</style>
