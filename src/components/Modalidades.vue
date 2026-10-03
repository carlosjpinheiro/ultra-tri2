<script setup>
import { computed, ref } from 'vue';
import { modalidadesAtivas } from '../data/modalidades';
import HomeSectionHeading from './HomeSectionHeading.vue';
const categoria = ref('todas');
const grupos = [{id:'todas',nome:'Todas'}, {id:'triathlon',nome:'Ultra Triathlon'}, {id:'corrida',nome:'Ultra Corridas'}, {id:'pedal',nome:'Ultra Ciclismo'}];
const grupoModalidade = modalidade => modalidade.id.startsWith('corrida-') ? 'corrida' : modalidade.id.startsWith('pedal-') ? 'pedal' : 'triathlon';
const modalidadesVisiveis = computed(() => modalidadesAtivas.filter(m => categoria.value === 'todas' || grupoModalidade(m) === categoria.value));
const quantidade = grupo => modalidadesAtivas.filter(m => grupo === 'todas' || grupoModalidade(m) === grupo).length;
</script>
<template>
  <section id="modalidades" class="ultra-section ultra-modalidades">
    <div class="ultra-container">
      <HomeSectionHeading eyebrow="Qual é o seu próximo limite?" title="Um desafio do seu tamanho." description="Do Meio Triathlon ao Deca. Da corrida de 3 horas ao pedal de 1.000 km. Escolha a sua experiência." />
      <div class="ultra-filters" role="group" aria-label="Filtrar modalidades"><button v-for="grupo in grupos" :key="grupo.id" type="button" :aria-pressed="categoria === grupo.id" class="ultra-filter" @click="categoria = grupo.id">{{ grupo.nome }} <span>{{ quantidade(grupo.id) }}</span></button></div>
      <div class="ultra-modalidade-grid" aria-live="polite">
        <article v-for="modalidade in modalidadesVisiveis" :key="modalidade.id" class="ultra-modalidade-card">
          <div class="ultra-card-top"><span class="ultra-eyebrow">{{ grupos.find(g => g.id === grupoModalidade(modalidade)).nome }}</span><img :src="modalidade.img" alt="" loading="lazy" /></div>
          <h3>{{ modalidade.titulo === 'Corrida' || modalidade.titulo === 'Ciclismo' ? modalidade.provas : modalidade.titulo }}</h3>
          <p v-if="modalidade.titulo !== 'Corrida' && modalidade.titulo !== 'Ciclismo'" class="ultra-distancias">{{ modalidade.provas }}</p>
          <div class="ultra-cortes"><span>Tempos de corte</span><ul><li v-for="corte in modalidade.cortes" :key="corte">{{ corte }}</li></ul></div>
          <RouterLink :to="{name:'inscricao'}" class="ultra-card-link" :aria-label="`Inscreva-se em ${modalidade.nome}`">Aceite o desafio <span aria-hidden="true">↗</span></RouterLink>
        </article>
      </div>
      <RouterLink :to="{name:'regulamentos'}" class="ultra-text-link ultra-section-link">Consulte os regulamentos completos ↗</RouterLink>
    </div>
  </section>
</template>
