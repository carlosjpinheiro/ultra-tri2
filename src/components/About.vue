<script setup>
import HomeSectionHeading from './HomeSectionHeading.vue';
import sobreImg from '../assets/images/sobre.png';
</script>
<template>
  <section id="sobre" class="ultra-section ultra-about">
    <div class="ultra-container ultra-about-grid">
      <div class="ultra-about-image"><img :src="sobreImg" alt="Brasil Ultra Tri, etapa da IUTA World Cup" loading="lazy" /></div>
      <div>
        <HomeSectionHeading eyebrow="O mundo se encontra em Búzios" title="Muito além da linha de chegada." />
        <p>Uma das etapas mais emblemáticas do circuito mundial, o Brasil Ultra Tri chega novamente em Búzios, trazendo ao país um evento inesquecível. Com o sucesso das edições anteriores, amplamente elogiadas por atletas ao redor do mundo, retornamos com a mesma excelência para a edição 2027.</p>
        <p>Realizado no Clube Aretê Búzios, o evento entrega estrutura, segurança, natureza exuberante e uma atmosfera única de superação, convivência e endurance extremo.</p>
        <p>Novamente, com a maior modalidade de triathlon da América Latina: o <strong>DECA ULTRA TRI</strong>. São 38 km de natação, 1.800 km de ciclismo e 422 km de corrida, de forma contínua.</p>
        <p>Além do DECA, as modalidades já conhecidas pelos nossos atletas: Quintuplo, Triplo e Duplo (Contínuo ou Um por Dia). Nesta edição também daremos foco às ultramaratonas e aos ultraciclismos.</p>
        <div class="ultra-iuta-copy"><h3>2027 IUTA World Cup</h3><p>Esta é a única competição no Brasil credenciada pela IUTA e a única prova oficial de Ultra Triathlon na América Latina atualmente, fazendo parte do calendário anual da instituição internacional.</p><a href="https://www.iutasport.com/" target="_blank" rel="noopener noreferrer" class="ultra-text-link">Conheça a Associação Internacional de Ultra Triathlon ↗</a></div>
      </div>
    </div>
  </section>
</template>
