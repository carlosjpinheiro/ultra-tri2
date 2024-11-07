<script setup lang="ts">
import { watch } from 'vue';
import { ref } from 'vue';

const props = defineProps({
  carregando: {
    type: Boolean,
    default: false
  },
})

const valor = ref(props.carregando)

watch(() => props.carregando, (newValue, oldValue) => {
  if (newValue !== oldValue) {
    valor.value = newValue
  }
});

</script>

<template>
  <VOverlay
    v-model="valor"
    class="align-center justify-center"
    persistent
  >
    <VProgressCircular
      color="primary"
      size="64"
      indeterminate
    />
  </VOverlay>
</template>
