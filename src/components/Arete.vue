<script setup>
import { ref } from 'vue';
import HomeCarousel from './HomeCarousel.vue';
import HomeSectionHeading from './HomeSectionHeading.vue';
import arete1 from '../assets/images/arete1.jpg';
import arete2 from '../assets/images/arete2.jpg';
import arete3 from '../assets/images/arete3.jpg';
import arete4 from '../assets/images/arete4.jpg';
import arete5 from '../assets/images/arete5.jpg';
const fotos = [arete1, arete2, arete3, arete4, arete5].map((src, index) => ({src, alt: `Vista ${index + 1} do Clube Aretê Búzios`}));
const fotoAtual = ref(0);
const estrutura = ['Piscina Olímpica (50 m)', 'Lago (500 m)', 'Pista para Ciclismo (7,560 km)', 'Pista para Corrida (1,00 km)', 'Banheiros', 'Área para Camping'];
</script>
<template>
  <section id="arete" class="ultra-section ultra-arete">
    <div class="ultra-container ultra-arete-grid">
      <div class="ultra-venue-images">
        <div class="ultra-venue-main"><HomeCarousel v-model="fotoAtual" :fotos="fotos" label="Fotos do Clube Aretê Búzios" /></div>
        <div class="ultra-venue-thumbs" role="group" aria-label="Selecionar foto do Clube Aretê">
          <button v-for="(foto, index) in fotos" :key="foto.src" type="button" :aria-label="`Ver foto ${index + 1} do Clube Aretê`" :aria-pressed="fotoAtual === index" @click="fotoAtual = index"><img :src="foto.src" :alt="foto.alt" loading="lazy" /></button>
        </div>
        <span class="ultra-image-tag ultra-venue-tag">O CENÁRIO DA SUA SUPERAÇÃO</span>
      </div>
      <div><HomeSectionHeading eyebrow="Natureza e estrutura no mesmo lugar" title="Bem-vindo ao Aretê." /><p class="ultra-description">O maior clube de triathlon da América Latina.</p><p>O evento irá ocorrer inteiramente dentro do Clube Aretê Búzios. A estrutura conta com:</p><ul class="ultra-venue-list"><li v-for="item in estrutura" :key="item"><span aria-hidden="true">↗</span>{{ item }}</li></ul><a href="https://www.aretebuzios.com.br/" target="_blank" rel="noopener noreferrer" class="ultra-text-link">Saiba mais sobre o clube ↗</a></div>
    </div>
  </section>
</template>
