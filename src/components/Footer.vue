<script setup>
import { contactInfo } from '../data/items';
import { formatPhone } from '../utils/utils';
const anoAtual = new Date().getFullYear();
const redes = [
  { label: 'Instagram', link: 'https://www.instagram.com/brasilultratri/', icon: 'icon-instagram' },
  { label: 'Facebook', link: 'https://www.facebook.com/brasilultratri/', icon: 'icon-facebook' },
];
</script>
<template>
  <footer class="site-footer ultra-site-footer">
    <div class="ultra-footer-inner">
      <div class="ultra-footer-grid">
        <div><h4>Brasil Ultra Eventos</h4><RouterLink :to="{name:'cancelamento'}">Política de reembolso e cancelamento</RouterLink></div>
        <div class="ultra-footer-contact"><h4>Contato</h4><a :href="`mailto:${contactInfo.email}`">{{ contactInfo.email }}</a><a :href="`https://wa.me/${contactInfo.phone}`" target="_blank" rel="noopener noreferrer"><span class="icon-whatsapp" aria-hidden="true"></span> {{ formatPhone(contactInfo.phone) }}</a></div>
        <div class="ultra-footer-social"><a v-for="rede in redes" :key="rede.label" :href="rede.link" :aria-label="rede.label" target="_blank" rel="noopener noreferrer"><span :class="rede.icon" aria-hidden="true"></span></a></div>
      </div>
      <p class="ultra-footer-copyright">Copyright {{ anoAtual }}. Todos direitos reservados.</p>
    </div>
  </footer>
</template>
