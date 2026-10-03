<script setup>
import { contactInfo } from '../data/items';
import { formatPhone } from '../utils/utils';
import HomeSectionHeading from './HomeSectionHeading.vue';
</script>
<template>
  <section id="contato" class="ultra-section ultra-contact">
    <div class="ultra-container ultra-contact-grid">
      <div><HomeSectionHeading eyebrow="Vamos conversar" title="A gente está com você." description="Tire suas dúvidas, faça um elogio ou reclamação." /><div class="ultra-contact-links"><a :href="`mailto:${contactInfo.email}`">{{ contactInfo.email }} <span aria-hidden="true">↗</span></a><a :href="`https://wa.me/${contactInfo.phone}`" target="_blank" rel="noopener noreferrer">{{ formatPhone(contactInfo.phone) }} <span aria-hidden="true">↗</span></a></div></div>
      <form class="ultra-contact-form" :action="`mailto:${contactInfo.email}`" method="GET">
        <div class="ultra-form-row"><div><label for="fname">Nome</label><input id="fname" type="text" autocomplete="given-name" class="ultra-input" /></div><div><label for="lname">Sobrenome</label><input id="lname" type="text" autocomplete="family-name" class="ultra-input" /></div></div>
        <label for="email">Email</label><input id="email" type="email" autocomplete="email" class="ultra-input" />
        <label for="message">Mensagem</label><textarea id="message" rows="5" class="ultra-input"></textarea>
        <button type="submit" class="ultra-button ultra-button-green">Enviar mensagem <span aria-hidden="true">↗</span></button>
      </form>
    </div>
  </section>
</template>
