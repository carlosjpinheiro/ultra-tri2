<script setup>
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

<style>
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
