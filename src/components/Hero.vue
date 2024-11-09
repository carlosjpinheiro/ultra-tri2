<script setup>
import mainPhoto from "../assets/images/LOGO_ULTRA_TRI_PRETA.png";
import { themeColor } from "../data/items";


</script>

<template>
  <div class="untree_co-hero" id="home">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12">
          <div class="dots"></div>
          <div class="row align-items-center">
            <div
              class="col-lg-6 ml-auto order-lg-2"
              data-aos="fade-right"
              data-aos-delay="400"
            >
              <img :src="mainPhoto" alt="Image" class="img-fluid" />
            </div>

           
            
            <div class="col-lg-6">
              <div>02 de maio de 2025 | Búzios/RJ</div>
              <br>
              <h1 class="heading" data-aos="fade-up" data-aos-delay="0">
                Brasil Ultra Tri 2025
              </h1>
              <div class="excerpt text-align-center" data-aos="fade-up" data-aos-delay="100">
                <p>
                  A Copa do Mundo de Ultra Triathlon volta ao Brasil em 2025, trazendo clima perfeito e cenário deslumbrante. 
                  Realizada no melhor clube esportivo da América Latina, a competição promete uma experiência inesquecível, 
                  unindo resistência, superação e infraestrutura de ponta!
                  
                </p>
                <h4>
                  VAGAS LIMITADAS!

                </h4>
              </div>
              <p data-aos="fade-up" data-aos-delay="200">
                <!-- <a
                  href="#features-section"
                  class="btn btn-primary smoothscroll"
                  style="margin-right: 5px"
                  :style="[
                    { background: themeColor },
                    { borderColor: themeColor },
                  ]"
                  >{{ buttonSeeFeature }}</a
                > -->
                <!-- <a
                  href="#pricing-section"
                  class="btn btn-outline-primary smoothscroll pricing"
                  :style="[{ color: themeColor }, { borderColor: themeColor }]"
                  >Inscreva-se!</a
                > -->
                  
                  <RouterLink 
                  :style="[
                    { color: themeColor }, 
                    { borderColor: themeColor }]"
                    class="btn smoothscroll pricing"
                    :to="{ name: 'inscricao',  }" 
                    >
                      Inscreva-se
                    </RouterLink>
                  
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
