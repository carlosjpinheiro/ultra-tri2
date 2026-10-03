<script setup>
import { ref } from 'vue';
import HomeCarousel from './HomeCarousel.vue';
import { fotosHome } from '../data/fotosHome';
const fotoAtual = ref(0);
const diasRestantes = Math.max(0, Math.ceil((new Date(2027, 4, 1) - new Date()) / 86400000));
</script>
<template>
  <section id="home" class="ultra-hero">
    <div class="ultra-container ultra-hero-grid">
      <div class="ultra-hero-copy">
        <p class="ultra-eyebrow"><span class="ultra-dot" aria-hidden="true"></span> IUTA World Cup · Búzios, Brasil</p>
        <h1 id="dstq-mundial" class="ultra-hero-title" aria-label="Mundial de Ultra Triathlon">
          <svg class="ultra-title-block" viewBox="0 0 600 340" aria-hidden="true" focusable="false">
            <text class="ultra-title-first" x="0" y="76" textLength="600" lengthAdjust="spacingAndGlyphs">MUNDIAL DE</text>
            <text id="dstq-ultra" x="0" y="230" textLength="600" lengthAdjust="spacingAndGlyphs">ULTRA</text>
            <text id="dstq-triat" x="0" y="325" textLength="600" lengthAdjust="spacingAndGlyphs">TRIATHLON</text>
          </svg>
        </h1>
        <p class="ultra-hero-edition">Brasil Ultra Tri <span>2027</span></p>
        <p class="ultra-hero-lead">Edições inesquecíveis. Cenário incrível.<br>Uma atmosfera de superação, 24 horas por dia.</p>
        <div class="ultra-actions">
          <RouterLink :to="{name: 'inscricao'}" class="ultra-button ultra-button-yellow">Garanta sua inscrição <span aria-hidden="true">↗</span></RouterLink>
          <a href="#modalidades" class="ultra-text-link">Encontre seu desafio <span aria-hidden="true">↓</span></a>
        </div>
        <div class="ultra-hero-date"><span>01 — 16 MAIO 2027</span><span>Clube Aretê · Búzios, RJ</span></div>
      </div>
      <div v-if="fotosHome.length" class="ultra-hero-visual">
        <div class="ultra-photo-main"><HomeCarousel v-model="fotoAtual" :fotos="fotosHome" label="Fotos do Brasil Ultra Tri" /><div class="ultra-photo-caption"><span>MAIS QUE UMA PROVA.</span><strong>Uma experiência ULTRA.</strong></div></div>
        <div v-if="diasRestantes > 0" class="ultra-countdown"><strong>{{ diasRestantes }}</strong><span>{{ diasRestantes === 1 ? 'dia' : 'dias' }} para<br>ir além.</span></div>
      </div>
    </div>
    <div class="ultra-hero-strip"><div class="ultra-container"><span>ENDURANCE SEM LIMITES</span><span aria-hidden="true">✳</span><span>UMA COMUNIDADE. MUITOS DESAFIOS.</span><span aria-hidden="true">✳</span><span>BRASIL ULTRA TRI 2027</span></div></div>
  </section>
</template>
