<script setup>
import { computed, ref } from 'vue';
import { formatarValor } from '../utils/utils';
import { lotes } from '../data/lotes';
import { modalidadesValores } from '../data/modalidades';
import HomeSectionHeading from './HomeSectionHeading.vue';
const hoje = new Date();
const loteEncerrado = lote => hoje > new Date(`${lote.dataFim}T23:59:59`);
const loteAtual = lotes.find(lote => (!lote.dataInicio || hoje >= new Date(`${lote.dataInicio}T00:00:00`)) && !loteEncerrado(lote));
const loteSelecionado = ref((loteAtual || lotes[lotes.length - 1]).chave);
const lote = computed(() => lotes.find(l => l.chave === loteSelecionado.value));
const formatarData = data => new Date(`${data}T00:00:00`).toLocaleDateString('pt-BR');
const periodo = computed(() => lote.value.dataInicio ? `${formatarData(lote.value.dataInicio)} a ${formatarData(lote.value.dataFim)}` : `Até ${formatarData(lote.value.dataFim)}`);
const status = computed(() => loteEncerrado(lote.value) ? 'Encerrado' : lote.value === loteAtual ? 'Lote atual' : 'Próximo lote');
const moedas = [{id:'USD',titulo:'Circuito mundial',descricao:'Valores em dólar americano, conforme padrão do circuito mundial.'},{id:'BRL',titulo:'Triathlon, corridas e ciclismo',descricao:'Valores em real brasileiro.'}];
const modalidadesDaMoeda = moeda => modalidadesValores.filter(m => m.moeda === moeda);
const valorInscricao = modalidade => modalidade.valores[lote.value.chave] == null ? '-' : formatarValor(modalidade.valores[lote.value.chave], modalidade.moeda);
</script>
<template>
  <section id="valores" class="ultra-section ultra-valores">
    <div class="ultra-container">
      <HomeSectionHeading eyebrow="Planeje a sua experiência" title="Seu próximo passo começa aqui." description="Confira os valores de inscrição por modalidade e lote." />
      <div class="ultra-filters" role="group" aria-label="Selecionar lote de inscrição"><button v-for="item in lotes" :key="item.chave" type="button" class="ultra-filter" :aria-pressed="loteSelecionado === item.chave" @click="loteSelecionado = item.chave">{{ item.destaque ? 'Promocional de abertura' : item.titulo }}<span v-if="item === loteAtual">Atual</span></button></div>
      <div class="ultra-lote-heading"><div><h3>{{ lote.titulo }}</h3><p>{{ periodo }}</p></div><span class="ultra-status" :class="{'is-closed':loteEncerrado(lote)}">{{ status }}</span></div>
      <div class="ultra-price-grid" aria-live="polite">
        <div v-for="moeda in moedas" :key="moeda.id" class="ultra-price-card">
          <div class="ultra-price-heading"><h3>{{ moeda.titulo }}</h3><span>{{ moeda.id }}</span></div>
          <ul><li v-for="modalidade in modalidadesDaMoeda(moeda.id)" :key="modalidade.id"><span>{{ modalidade.nome }}</span><strong>{{ valorInscricao(modalidade) }}</strong></li></ul>
          <p class="ultra-help">{{ moeda.descricao }}</p>
        </div>
      </div>
      <div class="ultra-included-grid">
        <div><h3>Formas de pagamento</h3><ul><li>À vista via Pix</li><li>Parcelado no cartão de crédito (consultar taxa da operadora)</li></ul></div>
        <div><h3>Está incluso na inscrição</h3><ul><li>Kit do atleta</li><li>Passe livre no Clube Aretê para atleta e staff durante os dias de prova</li><li>Alimentação: disponível conforme regulamento de cada modalidade</li></ul></div>
      </div>
      <div class="ultra-price-bottom"><p class="ultra-antidoping">Será realizado teste antidoping durante a competição, conforme regulamento da IUTA.</p><RouterLink :to="{name:'inscricao'}" class="ultra-button ultra-button-green">Inscreva-se <span aria-hidden="true">↗</span></RouterLink></div>
    </div>
  </section>
</template>
