<script setup>
import arete1 from "../assets/images/arete1.jpg";
import arete2 from "../assets/images/arete2.jpg";
import arete3 from "../assets/images/arete3.jpg";
import arete4 from "../assets/images/arete4.jpg";
import arete5 from "../assets/images/arete5.jpg";

const fotosCarousel = [
    arete1,
    arete2,
    arete3,
    arete4,
    arete5,
]
</script>

<template>
    <div class="untree_co-hero" id="arete">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12">
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
            
            <div class="col-lg-6 ">
                <h2 class="mb-6 text-uppercase">Clube Aretê Búzios</h2>
                <p class="text-uppercase negrito">O maior clube de triathlon da América Latina</p>
                <p class="negrito">O evento irá ocorrer inteiramente dentro do clube Aretê Búzios. A estrutura conta com:
                    <ul class="list-group my-4 ml-4">
                        <li >Piscina Olímpica (50 m)</li>
                        <li>Lago (500 m)</li>
                        <li>Pista para Ciclismo (7,560 km)</li>
                        <li>Pista para Corrida (2,00 km)</li>
                        <li>Banheiros</li>
                        <li>Área para Camping</li>                    
                    </ul>
                    <!-- <p>​Para conhecer melhor o clube, acesse o site:​</p> -->
                    
                    <a href="https://www.aretebuzios.com.br/" target="_blank" class="btn" style="text-decoration: underline;">
                        <h5 class="h3 negrito">Saiba mais sobre o clube</h5>
                    </a>
                </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<style>
</style>