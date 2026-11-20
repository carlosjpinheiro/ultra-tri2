<script setup>
import { VBtn, VCard, VCardActions, VCardText, VCardTitle, VDialog } from 'vuetify/components';

defineProps({
  modelValue: { type: Boolean, default: false },
  title: { type: String, required: true },
  message: { type: String, required: true },
  type: { type: String, default: 'info' },
  buttonText: { type: String, default: 'Entendi' },
});

const emit = defineEmits(['update:modelValue', 'closed']);
</script>

<template>
  <VDialog
    :model-value="modelValue"
    :aria-label="title"
    max-width="480"
    @update:model-value="emit('update:modelValue', $event)"
    @after-leave="emit('closed')"
  >
    <VCard class="message-dialog" :class="`message-dialog--${type}`">
      <VCardTitle class="message-dialog-title">{{ title }}</VCardTitle>
      <VCardText class="message-dialog-text">{{ message }}</VCardText>
      <VCardActions class="message-dialog-actions">
        <VBtn variant="flat" class="message-dialog-button" @click="emit('update:modelValue', false)">
          {{ buttonText }}
        </VBtn>
      </VCardActions>
    </VCard>
  </VDialog>
</template>

<style scoped>
.message-dialog {
  border-radius: 16px;
  border-top: 5px solid #176c43;
  color: #19372d;
  font-family: 'Nunito', sans-serif;
}
.message-dialog--error { border-top-color: #b23c32; }
.message-dialog-title { padding: 24px 24px 12px; font-weight: 800; white-space: normal; line-height: 1.4; }
.message-dialog-text { padding-inline: 24px; white-space: pre-line; overflow-wrap: anywhere; line-height: 1.8; }
.message-dialog-actions { padding: 16px 24px 24px; justify-content: flex-end; }
.message-dialog-button { background: #176c43; color: #fff; text-transform: none; font-weight: 700; padding-inline: 20px; }
.message-dialog--error .message-dialog-button { background: #b23c32; }
</style>
