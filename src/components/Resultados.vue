<script setup>
import { computed, nextTick, ref } from 'vue';
import results from '../data/resultados.json';

const years = [...new Set(results.map(event => event.year))].sort((a, b) => b - a);
const year = ref(years[0]);
const format = ref('all');
const search = ref('');
const normalize = value => value.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
const distanceOrder = { 'Double Deca': 20, Deca: 10, 'Quíntuplo': 5, Triplo: 3, Duplo: 2 };
const yearEvents = computed(() => results
  .filter(event => event.year === year.value)
  .sort((a, b) => distanceOrder[b.title] - distanceOrder[a.title]));
const entries = computed(() => yearEvents.value.flatMap(event => event.groups.flatMap(group => group.athletes)));
const recordCount = computed(() => entries.value.filter(athlete => athlete.flags.includes('record')).length);
const hasDaily = computed(() => yearEvents.value.some(event => event.format === 'daily'));
const visibleEvents = computed(() => yearEvents.value
  .filter(event => format.value === 'all' || event.format === format.value)
  .map(event => ({ ...event, groups: event.groups.map(group => ({ ...group,
    athletes: group.athletes.filter(athlete => normalize(`${athlete.name} ${athlete.country}`).includes(normalize(search.value.trim()))),
  })).filter(group => group.athletes.length) }))
  .filter(event => event.groups.length));
const splits = [['swim', 'Natação'], ['t1', 'T1'], ['bike', 'Ciclismo'], ['t2', 'T2'], ['run', 'Corrida']];
const flagLabels = { record: 'Recorde', DNF: 'DNF', DNS: 'DNS', DSQ: 'DSQ', DQ: 'DQ', overtime: 'Fora do tempo limite', incomplete: 'Parciais incompletas' };
const noteTranslations = {
  'New Continental Record': 'Novo recorde continental',
  'It ended after the timeout.': 'Concluiu fora do tempo limite.',
  'finished out of time': 'Concluiu fora do tempo limite.',
  'stopet in the pool': 'Interrompeu a prova na natação.',
};
const noteFor = athlete => (noteTranslations[athlete.note] || athlete.note || (athlete.flags.includes('DNF') ? 'Não terminou' : '')).replace(/\bDNF\b/gi, 'Não terminou');
const displayTime = value => /^dnf$/i.test(value?.trim() || '') ? '-' : value || '—';
const rowClass = athlete => ({ 'is-record': athlete.flags.includes('record'), 'is-condition': athlete.flags.some(flag => flag !== 'record') });
const partial = athlete => athlete.flags.some(flag => ['DNF', 'DNS', 'DSQ', 'DQ'].includes(flag)) && /^\d+:/.test(athlete.times.total);
function selectYear(value) {
  year.value = value;
  format.value = 'all';
}
async function tabKey(event, index) {
  const offsets = { ArrowRight: 1, ArrowLeft: -1, Home: -index, End: years.length - 1 - index };
  if (!(event.key in offsets)) return;
  event.preventDefault();
  const target = (index + offsets[event.key] + years.length) % years.length;
  selectYear(years[target]);
  await nextTick();
  document.getElementById(`year-tab-${years[target]}`)?.focus();
}
</script>

<template>
  <div id="resultados" class="ultra-page-body results-page">
    <div class="container">
      <div class="results-years" role="tablist" aria-label="Ano dos resultados">
        <button v-for="(item, index) in years" :id="`year-tab-${item}`" :key="item" type="button"
          role="tab" :aria-selected="year === item" aria-controls="year-results" :tabindex="year === item ? 0 : -1"
          @click="selectYear(item)" @keydown="tabKey($event, index)">{{ item }}</button>
      </div>

      <section id="year-results" role="tabpanel" :aria-labelledby="`year-tab-${year}`" tabindex="0">
        <div class="results-overview">
          <div><p class="ultra-eyebrow">Edição {{ year }}</p><h2>Resultados da prova</h2></div>
          <div class="results-stats" aria-label="Resumo da edição">
            <span><strong>{{ entries.length }}</strong> participações</span>
            <span><strong>{{ yearEvents.length }}</strong> modalidades</span>
            <span><strong>{{ recordCount }}</strong> recordes registrados</span>
          </div>
        </div>

        <div class="results-toolbar">
          <div class="results-formats" aria-label="Formato da prova">
            <button v-for="item in [{ value: 'all', label: 'Todas' }, { value: 'continuous', label: 'Contínuo' }, ...(hasDaily ? [{ value: 'daily', label: 'Um por dia' }] : [])]"
              :key="item.value" type="button" :aria-pressed="format === item.value" @click="format = item.value">{{ item.label }}</button>
          </div>
          <label class="results-search">Buscar atleta ou país
            <input v-model="search" type="search" placeholder="Nome do atleta ou país" />
          </label>
        </div>

        <div v-if="!visibleEvents.length" class="results-empty">
          <h3>Nenhum resultado encontrado</h3>
          <p>Tente outro nome, país ou formato de prova.</p>
          <button type="button" class="ultra-button ultra-button-green" @click="search = ''; format = 'all'">Limpar filtros</button>
        </div>

        <article v-for="event in visibleEvents" :key="event.id" class="results-event" :aria-labelledby="event.id">
          <header class="results-event-heading">
            <div><p class="ultra-eyebrow">{{ event.format === 'daily' ? 'Um por dia' : 'Contínuo' }}</p><h3 :id="event.id">{{ event.title }}</h3></div>
            <span class="results-event-tag">{{ event.format === 'daily' ? `${event.days} dias` : 'Prova contínua' }}</span>
          </header>

          <section v-for="group in event.groups" :key="group.category" class="results-category">
            <h4>{{ group.category }} <span>{{ group.athletes.length }} {{ group.athletes.length === 1 ? 'atleta' : 'atletas' }}</span></h4>
            <p v-if="event.format === 'daily' && year === 2022" class="results-table-note">“Tempo informado” reproduz o campo final da planilha de 2022; não representa a soma dos dias.</p>
            <div class="results-scroll" role="region" :aria-label="`${event.title} ${event.format === 'daily' ? 'um por dia' : 'contínuo'} — ${group.category} ${year}. Tabela com rolagem horizontal.`" tabindex="0">
              <table class="results-table">
                <caption class="results-sr-only">{{ event.title }} — {{ group.category }} — {{ year }}</caption>
                <thead><tr>
                  <th scope="col">Pos.</th><th scope="col">Atleta</th><th scope="col">País</th>
                  <template v-if="event.format === 'continuous'"><th v-for="[key, label] in splits" :key="key" scope="col">{{ label }}</th><th scope="col">Total</th></template>
                  <template v-else><th v-for="day in event.days" :key="day" scope="col">Dia {{ day }}</th><th v-if="year === 2022" scope="col">Tempo informado</th></template>
                  <th scope="col">Observações</th>
                </tr></thead>
                <tbody><tr v-for="athlete in group.athletes" :key="athlete.sourceRow" :class="rowClass(athlete)">
                  <td class="results-position">{{ athlete.position }}</td>
                  <th scope="row" class="results-athlete">{{ athlete.name }}
                    <span v-if="athlete.flags.length" class="results-badges"><span v-for="flag in athlete.flags" :key="flag" class="results-badge" :class="flag === 'record' ? 'badge-record' : 'badge-condition'">{{ flagLabels[flag] }}</span></span>
                  </th>
                  <td>{{ athlete.country || '—' }}</td>
                  <template v-if="event.format === 'continuous'">
                    <td v-for="[key] in splits" :key="key" class="results-time">{{ displayTime(athlete.times[key]) }}</td>
                    <td class="results-time results-total">{{ displayTime(athlete.times.total) }}<small v-if="partial(athlete)">Tempo parcial</small></td>
                  </template>
                  <template v-else><td v-for="(day, index) in athlete.daily" :key="index" class="results-time">{{ displayTime(day.total) }}</td><td v-if="year === 2022" class="results-time results-total">{{ displayTime(athlete.finish) }}</td></template>
                  <td class="results-note">{{ noteFor(athlete) || '—' }}</td>
                </tr></tbody>
              </table>
            </div>
          </section>
        </article>
      </section>
    </div>
  </div>
</template>

<style scoped>
.results-years { display: flex; gap: 8px; border-bottom: 1px solid var(--ultra-line); margin-bottom: 34px; padding-bottom: 12px; }
.results-years button { border: 1px solid var(--ultra-line); background: white; color: var(--ultra-forest); border-radius: 8px; padding: 12px 28px; font-size: 18px; font-weight: 800; cursor: pointer; }
.results-years button[aria-selected="true"] { background: var(--ultra-forest); color: white; border-color: var(--ultra-forest); box-shadow: inset 0 -4px var(--ultra-yellow); }
.results-overview { display: flex; align-items: center; justify-content: space-between; gap: 24px; margin-bottom: 26px; }
.results-overview .ultra-eyebrow { margin-bottom: 8px; }
.results-overview h2 { margin: 0; font-size: 30px; }
.results-stats { display: flex; gap: 28px; }
.results-stats span { display: flex; flex-direction: column; font-size: 12px; color: var(--ultra-muted); }
.results-stats strong { font-size: 28px; line-height: 1.4; }
.results-toolbar { display: flex; justify-content: space-between; align-items: end; gap: 20px; padding: 20px; margin-bottom: 24px; background: #eaf0e7; border-radius: 12px; }
.results-formats { display: flex; gap: 6px; flex-wrap: wrap; }
.results-formats button { background: transparent; border: 1px solid #b9cbbd; color: var(--ultra-forest); border-radius: 6px; padding: 10px 18px; font-size: 14px; font-weight: 800; cursor: pointer; }
.results-formats button[aria-pressed="true"] { color: white; background: var(--ultra-forest); border-color: var(--ultra-forest); }
.results-search { display: flex; flex-direction: column; gap: 4px; font-size: 12px; font-weight: 800; width: min(100%, 320px); }
.results-search input { width: 100%; min-height: 44px; padding: 10px 14px; background: white; border: 1px solid #a2b3a7; border-radius: 6px; color: var(--ultra-ink); font-size: 14px; }
.results-event { border: 1px solid var(--ultra-line); border-radius: 16px; overflow: hidden; background: white; margin-bottom: 30px; }
.results-event-heading { display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 24px; background: #edf2e9; }
.results-event-heading .ultra-eyebrow { margin: 0 0 6px; font-size: 10px; }
.results-event-heading h3 { margin: 0; font-size: 28px; }
.results-event-tag { border: 1px solid #bdcdbf; border-radius: 30px; padding: 6px 12px; font-size: 12px; white-space: nowrap; }
.results-category { padding-top: 22px; }
.results-category h4 { margin: 0 24px 16px; font-size: 17px; }
.results-category h4 span { font-size: 12px; font-weight: 400; color: var(--ultra-muted); margin-left: 8px; }
.results-scroll { overflow-x: auto; max-width: 100%; scrollbar-color: #98ae9c #edf2e9; }
.results-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; line-height: 1.5; }
.results-table th, .results-table td { padding: 16px 12px; border-bottom: 1px solid #e4e9e0; vertical-align: top; }
.results-table thead th { background: #f6f8f3; color: var(--ultra-muted); font-size: 11px; font-weight: 800; white-space: nowrap; }
.results-table th:first-child, .results-table td:first-child { padding-left: 24px; }
.results-position { font-weight: 800; color: var(--ultra-muted); }
.results-athlete { min-width: 190px; max-width: 260px; font-weight: 800; }
.results-time { white-space: nowrap; font-variant-numeric: tabular-nums; }
.results-total { font-weight: 800; }
.results-total small { display: block; font-size: 10px; font-weight: 400; }
.results-note { min-width: 180px; font-size: 12px; }
.results-table .is-record { background: #fff7d9; }
.results-table .is-condition { background: #fff1e9; }
.results-table .is-record > :first-child { box-shadow: inset 4px 0 #d69a00; }
.results-table .is-condition > :first-child { box-shadow: inset 4px 0 #b34d1d; }
.results-badges { display: flex; flex-wrap: wrap; gap: 4px; margin-top: 7px; }
.results-badge { display: inline-block; padding: 3px 7px; border-radius: 4px; font-size: 10px; line-height: 1.5; font-weight: 800; }
.badge-record { background: #fbe397; color: #634700; }.badge-condition { background: #ffe0cf; color: #83330d; }
.results-table-note { margin: 0 24px 14px; font-size: 12px; }
.results-empty { padding: 40px 24px; border: 1px solid var(--ultra-line); border-radius: 12px; margin-bottom: 30px; text-align: center; }
.results-sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip-path: inset(50%); white-space: nowrap; }
@media (max-width: 900px) {
  .results-overview { align-items: start; flex-direction: column; }
  .results-toolbar { align-items: stretch; flex-direction: column; }
  .results-search { width: 100%; }
}
@media (max-width: 479px) {
  .results-years { gap: 6px; }.results-years button { flex: 1; font-size: 16px; padding: 12px 8px; }
  .results-stats { gap: 16px; }.results-stats span { font-size: 10px; }.results-stats strong { font-size: 24px; }
  .results-toolbar { padding: 16px; }.results-formats button { padding: 10px 12px; font-size: 12px; }
  .results-event-heading { padding: 20px; }.results-event-heading h3 { font-size: 25px; }
  .results-event-tag { font-size: 10px; }.results-category h4 { margin-inline: 20px; }
}
</style>
