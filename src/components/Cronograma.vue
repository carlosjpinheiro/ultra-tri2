<script setup>
import { cronograma, entregaKit, premiacao } from '../data/cronograma';
const informacoes = [
  { titulo: 'Entrega de kit', itens: entregaKit, prefixo: 'Início', observacoes: [] },
  { titulo: 'Premiação', itens: premiacao, prefixo: 'Horário', observacoes: [
    'Atletas do Deca Contínuo e Deca um Por Dia serão premiados após sua linha de chegada.',
    'Atletas que não poderão comparecer na cerimônia de premiação poderão ser premiados após sua linha de chegada — informar a organização no dia.'
  ] }
];
</script>
<template>
  <div class="ultra-page-body page-cronograma">
    <div class="container ultra-schedule-grid" id="cronograma">
      <section aria-labelledby="schedule-starts">
        <h2 id="schedule-starts">Largadas</h2>
        <p class="ultra-schedule-notice">Em caso de alterações no cronograma, o atleta será avisado.</p>
        <div class="ultra-schedule-list">
          <article v-for="item in cronograma" :key="item.data" class="ultra-schedule-card">
            <h3>{{ item.data }}</h3>
            <div v-for="evento in item.atividades" :key="evento.horario + evento.descricao" class="ultra-schedule-event">
              <span v-if="evento.horario" class="ultra-schedule-time">{{ evento.horario }}</span>
              <p>{{ evento.descricao }}</p>
            </div>
            <p v-if="item.observacao" class="ultra-help">{{ item.observacao }}</p>
          </article>
        </div>
      </section>
      <div>
        <section v-for="(grupo, index) in informacoes" :key="grupo.titulo" class="ultra-schedule-info" :aria-labelledby="'schedule-info-' + index">
          <h2 :id="'schedule-info-' + index">{{ grupo.titulo }}</h2>
          <div class="ultra-schedule-list">
            <article v-for="item in grupo.itens" :key="item.titulo" class="ultra-schedule-card">
              <h3>{{ item.titulo }}</h3>
              <div v-for="evento in item.eventos" :key="evento.horario + evento.descricao" class="ultra-schedule-event">
                <span v-if="evento.horario" class="ultra-schedule-time">{{ grupo.prefixo }}: {{ evento.horario }}</span>
                <p>{{ evento.descricao }}</p>
              </div>
              <p v-if="item.observacao" class="ultra-help">{{ item.observacao }}</p>
            </article>
          </div>
          <p v-for="texto in grupo.observacoes" :key="texto" class="ultra-schedule-notice">{{ texto }}</p>
        </section>
      </div>
    </div>
  </div>
</template>
