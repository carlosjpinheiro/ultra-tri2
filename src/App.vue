<script setup>
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";

window.gtranslateSettings = {
  "default_language":"pt",
  "native_language_names":true,
  "detect_browser_language":true,
  "languages":["pt","fr","de","it","es","en","ru"],
  "wrapper_selector":".gtranslate_wrapper",
  "switcher_horizontal_position":"right",
  "alt_flags":{
    "pt":"brazil"
  }
}

</script>

<template>
  <!-- <Header />
  <Hero />
  <About />
  <Testimonial />
  <Contact />
  <Footer /> -->
  <div id="app">
    <div class="gtranslate_wrapper"/>
    <Header />
    <RouterView />
    <Footer />
</div>

</template>
