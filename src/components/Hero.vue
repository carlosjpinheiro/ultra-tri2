<script setup>
import { themeColor } from "../data/items";
import { challengeInfo } from '../data/items';

// Todas as fotos desta pasta entram no carrossel, em ordem de nome.
const imagensCarousel = import.meta.glob('../assets/images/hero/*', {
  eager: true,
  import: 'default',
  as: 'url',
})

const fotosCarousel = Object.entries(imagensCarousel)
  .filter(([caminho]) => /\.(jpe?g|png|webp|avif|gif)$/i.test(caminho))
  .sort(([a], [b]) => a.localeCompare(b, 'pt-BR', { numeric: true }))
  .map(([, url]) => url)

// 01 de maio de 2027
const diaEvento = new Date(2027, 4, 1)
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
                  :key="foto"
                  :src="foto"
                  cover
                />
              </VCarousel>

            </div>
            
            <div class="col-lg-6 text-center">
              <div v-if="diasRestantes > 0"><strong>{{ diasRestantes }} {{ diasRestantes == 1 ? 'DIA' : 'DIAS' }} PARA O EVENTO</strong></div>

              <div >01 a 15 de maio de 2027 | Clube Aretê Búzios, RJ</div>
              <br>
              <h1 class="text-uppercase" style="font-size: 47px; background-color: #fcb603; border-radius: 10px;" data-aos="fade-up" data-aos-delay="0">
                Brasil Ultra Tri 2027
              </h1>
              <div class="excerpt text-align-center" data-aos="fade-up" data-aos-delay="100">
                <b><p class="mb-2">
                  Edições inesquecíveis. Cenário incrível. 
                  <br>Atmosfera ULTRA 24 horas por dia.
                </p></b> 
                  <p>
                    O Brasil Ultra Tri retorna em 2027, reunindo atletas de diferentes partes do mundo em uma
                    experiência que vai muito além do esporte.</p>
                    <p>Realizado no Clube Aretê Búzios, considerado um dos melhores complexos esportivos da
                    América Latina, o evento entrega estrutura, segurança, natureza exuberante e uma
                    atmosfera única de superação, convivência e endurance extremo.</p>
                    <p>Dias e noites de prova. Emoção constante. Uma comunidade unida pela coragem de ir além.
                    Mais do que uma competição: <b>uma experiência ULTRA!</b>

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
              <!-- <p data-aos="fade-up" data-aos-delay="200">

                    <a :href="challengeInfo.resultPage" target="_blank">
              
                      <span style="font-size: 18px; color: green; border-color: green;" 
                      class="btn smoothscroll pricing "
                      >
                        RESULTADO AO VIVO
  
                      </span>

                    </a>
                  
              </p>  -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
