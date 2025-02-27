<script setup>
import carousel1 from "../assets/images/carousel1.jpg";
import carousel2 from "../assets/images/carousel2.png";
import carousel3 from "../assets/images/carousel3.jpg";
import carousel4 from "../assets/images/carousel4.jpg";
import carousel5 from "../assets/images/carousel5.jpg";
import carousel6 from "../assets/images/carousel6.jpg";
import carousel7 from "../assets/images/carousel7.jpg";
import carousel8 from "../assets/images/carousel8.jpg";
import carousel9 from "../assets/images/carousel9.jpg";

import { themeColor } from "../data/items";

const fotosCarousel = [
  carousel1,
  carousel2,
  carousel3,
  carousel4,
  carousel5,
  carousel6,
  carousel7,
  carousel8,
  carousel9,
]

// 01 de maio de 2025
const diaEvento = new Date(2025, 4, 1)
const hoje = new Date(); 

const diasAteData = () => { 
  const diffMilissegundos = diaEvento - hoje; 
  const diasRestantes = Math.ceil(diffMilissegundos / (1000 * 60 * 60 * 24)); 
  return diasRestantes; 
}

const diasRestantes = diasAteData()

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

              <VCarousel
                style="border-radius: 50px;"
                class="img-border mb-4"
                hide-delimiters
                show-arrows="hover" 
                cycle
              >
                <VCarouselItem
                  v-for="foto in fotosCarousel"
                  :src="foto"
                  cover
                />
              </VCarousel>

            </div>
            
            <div class="col-lg-6 text-center">
              <div v-if="diasRestantes > 0"><strong>{{ diasRestantes }} DIAS PARA O EVENTO</strong></div>

              <div >01 a 15 de maio de 2025 | Clube Aretê Búzios, RJ</div>
              <br>
              <h1 class="text-uppercase" style="font-size: 47px; background-color: #fcb603; border-radius: 10px;" data-aos="fade-up" data-aos-delay="0">
                Brasil Ultra Tri 2025
              </h1>
              <div class="excerpt text-align-center" data-aos="fade-up" data-aos-delay="100">
                <p class="mb-5">
                  A Copa do Mundo de Ultra Triathlon volta ao Brasil em 2025, trazendo clima perfeito e cenário deslumbrante. 
                </p>
                  <p>
                    Realizada no melhor clube esportivo da América Latina, a competição promete uma experiência inesquecível, 
                    unindo resistência, superação e infraestrutura de ponta!

                  </p>
                  
                
              </div>
              <p data-aos="fade-up" data-aos-delay="200">
                  
                  <RouterLink 
                  :style="[
                    { color: themeColor }, 
                    { borderColor: themeColor }]"
                    class="btn smoothscroll pricing "
                    :to="{ name: 'inscricao',  }" 
                    >
                    <span style="font-size: 14px;">
                      Inscreva-se

                    </span>
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
