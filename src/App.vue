<script setup>
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";
</script>

<template>
  <!-- <Header />
  <Hero />
  <About />
  <Testimonial />
  <Contact />
  <Footer /> -->
  <div id="app" class="site-bg ">
    <Header />
    <RouterView />
    <Footer />
</div>

</template>

<style>
.site-bg{
  background-color: #fffc5b81;
  color: rgba(0, 0, 0, 0.753);
}

</style>