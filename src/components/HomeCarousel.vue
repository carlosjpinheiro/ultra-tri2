<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
defineProps({ fotos: { type: Array, required: true }, modelValue: { type: Number, default: 0 }, label: String });
const emit = defineEmits(['update:modelValue']);
const pausado = ref(false);
const reduzirMovimento = ref(false);
let preferencia;
const atualizarPreferencia = () => { reduzirMovimento.value = preferencia.matches; };
onMounted(() => {
  preferencia = window.matchMedia('(prefers-reduced-motion: reduce)');
  atualizarPreferencia();
  preferencia.addEventListener('change', atualizarPreferencia);
});
onUnmounted(() => preferencia?.removeEventListener('change', atualizarPreferencia));
</script>
<template>
  <div class="ultra-carousel" role="region" :aria-label="label">
    <VCarousel :model-value="modelValue" @update:model-value="emit('update:modelValue', $event)" height="100%" hide-delimiters :cycle="!pausado && !reduzirMovimento" :interval="6000" :show-arrows="fotos.length > 1">
      <template #prev="{ props }"><VBtn v-bind="props" icon="mdi-chevron-left" class="ultra-carousel-arrow" aria-label="Foto anterior" /></template>
      <template #next="{ props }"><VBtn v-bind="props" icon="mdi-chevron-right" class="ultra-carousel-arrow" aria-label="Próxima foto" /></template>
      <VCarouselItem v-for="(foto, index) in fotos" :key="foto.src" :value="index">
        <img :src="foto.src" :alt="foto.alt || `Momento ${index + 1} do Brasil Ultra Tri`" class="ultra-carousel-image" :loading="index === 0 ? 'eager' : 'lazy'" />
      </VCarouselItem>
    </VCarousel>
    <button v-if="fotos.length > 1" type="button" class="ultra-carousel-pause" :aria-label="pausado ? 'Reproduzir carrossel' : 'Pausar carrossel'" @click="pausado = !pausado">{{ pausado ? '▶' : 'Ⅱ' }}</button>
  </div>
</template>
