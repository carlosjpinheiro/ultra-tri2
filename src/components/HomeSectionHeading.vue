<script setup>
defineProps({ eyebrow: String, title: String, description: String });
</script>
<template>
  <div class="ultra-section-heading">
    <p v-if="eyebrow" class="ultra-eyebrow">{{ eyebrow }}</p>
    <h2>{{ title }}</h2>
    <p v-if="description" class="ultra-description">{{ description }}</p>
    <slot />
  </div>
</template>
