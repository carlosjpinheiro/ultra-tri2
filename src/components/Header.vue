<script setup>
import { computed, nextTick, onMounted, onUnmounted, ref, watch } from 'vue';
import { RouterLink, useRoute } from 'vue-router';
import { themeColor } from '../data/items';
import ultraTriImg from '../assets/images/LOGOS_ULTRA_TRI_sem_bixo_fino.png';
import '../styles/layout.css';

// A ordem também define a prioridade dos links que ficam fora do Mais.
const links = [
  { name: 'cronograma', label: 'Cronograma' },
  { name: 'modalidades', label: 'Modalidades' },
  { name: 'percurso', label: 'Percurso' },
  { name: 'regulamentos', label: 'Regulamentos' },
  { name: 'valores', label: 'Valores' },
  { name: 'alojamento', label: 'Alojamento' },
  { name: 'comochegar', label: 'Como chegar' },
  { name: 'organizacao', label: 'Organização' },
  { name: 'sobre', label: 'Sobre' },
  { name: 'resultados2025', label: 'Resultados 2025' },
  { name: 'contato', label: 'Contato' },
];
const route = useRoute();
const header = ref(null);
const espacoMenu = ref(null);
const medidor = ref(null);
const botaoMais = ref(null);
const quantidadeVisivel = ref(0);
const aberto = ref(false);
const visiveis = computed(() => links.slice(0, quantidadeVisivel.value));
const restantes = computed(() => links.slice(quantidadeVisivel.value));
let observer;
let ativo = true;

const distribuir = () => {
  if (!ativo || !espacoMenu.value || !medidor.value) return;
  const largura = espacoMenu.value.clientWidth;
  const itens = Array.from(medidor.value.querySelectorAll('[data-menu-item]'));
  const gap = parseFloat(getComputedStyle(medidor.value).columnGap) || 0;
  const larguras = itens.map(item => item.getBoundingClientRect().width);
  const larguraMais = medidor.value.querySelector('[data-menu-more]').getBoundingClientRect().width;
  const total = larguras.reduce((soma, valor) => soma + valor, 0) + gap * (links.length - 1);
  if (total <= largura) {
    quantidadeVisivel.value = links.length;
    aberto.value = false;
    return;
  }
  let ocupado = larguraMais;
  let quantidade = 0;
  for (const item of larguras) {
    if (ocupado + gap + item > largura) break;
    ocupado += gap + item;
    quantidade++;
  }
  quantidadeVisivel.value = quantidade;
};
const fechar = () => { aberto.value = false; };
const fora = evento => { if (!header.value?.contains(evento.target)) fechar(); };
const teclado = evento => {
  if (evento.key === 'Escape' && aberto.value) { fechar(); botaoMais.value?.focus(); }
};
watch(() => route.fullPath, fechar);
onMounted(async () => {
  await nextTick();
  observer = new ResizeObserver(distribuir);
  observer.observe(espacoMenu.value);
  observer.observe(medidor.value);
  distribuir();
  document.fonts?.ready.then(distribuir);
  document.addEventListener('pointerdown', fora);
  document.addEventListener('keydown', teclado);
});
onUnmounted(() => {
  ativo = false;
  observer?.disconnect();
  document.removeEventListener('pointerdown', fora);
  document.removeEventListener('keydown', teclado);
});
</script>

<template>
  <header ref="header" class="ultra-site-header" :style="{'--header-green': themeColor}">
    <div class="ultra-header-bar">
      <RouterLink :to="{name:'home'}" class="ultra-header-logo" aria-label="Brasil Ultra Tri — página inicial" @click="fechar"><img :src="ultraTriImg" alt="Brasil Ultra Tri" /></RouterLink>
      <nav ref="espacoMenu" class="ultra-nav-space" aria-label="Navegação principal">
        <ul class="ultra-nav-list">
          <li v-for="link in visiveis" :key="link.name"><RouterLink :to="{name:link.name}" class="ultra-nav-link" @click="fechar">{{ link.label }}</RouterLink></li>
          <li v-if="restantes.length" class="ultra-nav-overflow">
            <button ref="botaoMais" type="button" class="ultra-nav-link ultra-more-button" :aria-expanded="aberto" aria-controls="ultra-more-links" @click="aberto = !aberto">Mais <span aria-hidden="true">⌄</span></button>
            <ul v-if="aberto" id="ultra-more-links" class="ultra-more-links">
              <li v-for="link in restantes" :key="link.name"><RouterLink :to="{name:link.name}" class="ultra-nav-link" @click="fechar">{{ link.label }}</RouterLink></li>
            </ul>
          </li>
        </ul>
      </nav>
      <RouterLink :to="{name:'inscricao'}" class="ultra-header-cta" @click="fechar">Inscreva-se</RouterLink>
      <div class="ultra-nav-measure-clip" aria-hidden="true" inert><div ref="medidor" class="ultra-nav-measure">
        <span v-for="link in links" :key="link.name" data-menu-item class="ultra-nav-link">{{ link.label }}</span>
        <span data-menu-more class="ultra-nav-link ultra-more-button">Mais <span>⌄</span></span>
      </div></div>
    </div>
  </header>
</template>
