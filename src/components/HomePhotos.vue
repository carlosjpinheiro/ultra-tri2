<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { fotosHome } from '../data/fotosHome';
import HomeSectionHeading from './HomeSectionHeading.vue';
const galeria = ref(null);
const inicio = ref(true);
const fim = ref(false);
let observer;
const atualizar = () => {
  if (!galeria.value) return;
  inicio.value = galeria.value.scrollLeft <= 1;
  fim.value = galeria.value.scrollLeft + galeria.value.clientWidth >= galeria.value.scrollWidth - 2;
};
const mover = direcao => {
  const reduzirMovimento = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  galeria.value?.scrollBy({ left: direcao * galeria.value.clientWidth * 0.8, behavior: reduzirMovimento ? 'instant' : 'smooth' });
};
onMounted(() => { observer = new ResizeObserver(atualizar); if (galeria.value) observer.observe(galeria.value); atualizar(); });
onUnmounted(() => observer?.disconnect());
</script>
<template>
  <section v-if="fotosHome.length" class="ultra-section ultra-gallery" aria-labelledby="gallery-title">
    <div class="ultra-container ultra-heading-row">
      <HomeSectionHeading eyebrow="Quem vive, leva para sempre" title="A energia de estar aqui." id="gallery-title" description="Dias e noites de prova. Histórias reais. Uma comunidade unida pela coragem de ir além." />
      <div class="ultra-gallery-controls"><button type="button" class="ultra-icon-button" :disabled="inicio" aria-label="Fotos anteriores" @click="mover(-1)">←</button><button type="button" class="ultra-icon-button" :disabled="fim" aria-label="Próximas fotos" @click="mover(1)">→</button></div>
    </div>
    <div ref="galeria" class="ultra-photo-rail" tabindex="0" role="region" aria-label="Fotos do Brasil Ultra Tri, use as setas do teclado ou deslize para navegar" @scroll.passive="atualizar">
      <figure v-for="(foto, index) in fotosHome" :key="foto.nome" class="ultra-gallery-photo"><img :src="foto.src" :alt="`Momento ${index + 1} do Brasil Ultra Tri`" loading="lazy" /><figcaption><span>BRASIL ULTRA TRI</span><span>{{ String(index + 1).padStart(2, '0') }} / {{ fotosHome.length }}</span></figcaption></figure>
    </div>
  </section>
</template>
