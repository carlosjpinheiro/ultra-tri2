<script setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';
const route = useRoute();
const pages = {
  cronograma: ['Prepare sua experiência', 'Cronograma 2027', 'Largadas, entrega de kits e premiação. Todos os momentos da sua prova.'],
  percurso: ['O cenário da sua superação', 'Conheça o percurso.', 'Estrutura e circuitos do Clube Aretê Búzios.'],
  regulamentos: ['Tudo para a sua prova', 'Regulamentos.', 'Consulte os documentos e prepare-se para o seu desafio.'],
  alojamento: ['Planeje sua estadia', 'Alojamento da prova.', 'Opções para descansar e viver a experiência do Brasil Ultra Tri.'],
  comochegar: ['Seu destino é Búzios', 'Como chegar?', 'Conheça o local da prova e as opções de transporte e hospedagem.'],
  organizacao: ['Quem faz acontecer', 'Nossa organização.', 'Conheça as pessoas por trás do Brasil Ultra Tri.'],
  cancelamento: ['Informações para o atleta', 'Reembolso e cancelamento.', 'Políticas de inscrição, troca de modalidade e hospedagem.'],
  startlist: ['Nossa comunidade', 'Atletas confirmados 2025.', 'Conheça os atletas de cada modalidade.'],
  resultados2025: ['Cada chegada, uma história', 'Resultados 2025.', 'Confira os resultados por modalidade da edição 2025.'],
  inscricao: ['Seu próximo passo começa aqui', 'Pré-inscrição 2027.', 'Preencha seus dados para participar do Brasil Ultra Tri.'],
  triopen: ['Brasil Tri Open 2025', 'O preview do Brasil Ultra Tri.', 'Informações e modalidades do Brasil Tri Open.'],
  inscricaotriopen: ['Brasil Tri Open · Outubro 2025', 'Faça sua pré-inscrição.', 'Preencha seus dados para participar do Brasil Tri Open.'],
};
const page = computed(() => pages[route.name] || ['Brasil Ultra Tri', 'Sua experiência Ultra.', '']);
</script>
<template>
  <main class="ultra-page" :class="`ultra-page-${route.name}`">
    <section class="ultra-page-heading">
      <div class="ultra-container">
        <RouterLink :to="{ name: 'home' }" class="ultra-page-back">← Página inicial</RouterLink>
        <p class="ultra-eyebrow">{{ page[0] }}</p>
        <h1>{{ page[1] }}</h1>
        <p class="ultra-page-lead">{{ page[2] }}</p>
      </div>
    </section>
    <slot />
  </main>
</template>
