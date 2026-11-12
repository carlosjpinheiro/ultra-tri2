<script setup>
import { computed, watch } from 'vue';
import { useRoute } from 'vue-router';
const route = useRoute();
const isHome = computed(() => route.name === 'home');
const isAdmin = computed(() => route.meta.admin === true);
watch(isAdmin, value => document.body.classList.toggle('ultra-admin-page', value), { immediate: true });

import SitePage from './components/SitePage.vue';
import './styles/theme.css';
import './styles/pages.css';

import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";

window.gtranslateSettings = {
  "default_language":"pt",
  "native_language_names":true,
  "detect_browser_language":false,
  "languages":["pt","fr","de","it","es","en","ru"],
  "wrapper_selector":".gtranslate_wrapper",
  "switcher_horizontal_position":"right",
  "alt_flags":{
    "pt":"brazil"
  }
}

</script>

<template>
  <div id="app" class="ultra-theme">
    <div v-show="!isAdmin" class="gtranslate_wrapper"/>
    <Header v-if="!isAdmin" />
    <RouterView v-slot="{ Component }">
      <component :is="Component" v-if="isHome || isAdmin" />
      <SitePage v-else><component :is="Component" /></SitePage>
    </RouterView>
    <Footer v-if="!isAdmin" />
</div>

</template>

<style>
body.ultra-admin-page > #overlayer,
body.ultra-admin-page > .loader {
  display: none !important;
}

.img-border {
  border: 6px;
  border-color: #fcb603;
  border-style: solid;
  border-radius: 50px;
}

.negrito {
    font-weight: 600;
}

.borda-preta {
    border: 2px solid black;
}

.fundo-claro {
    background-color: #fcb60333;
    border-radius: 5px;
    padding: 8px 0;
}
</style>
