<script setup>
import { themeColor } from "../data/items";
import sobreImg from "../assets/images/sobre.png";


</script>

<template>
  <div class="untree_co-section" id="sobre">
    <div class="container">
      <div class="row justify-content-between ">

        <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
          <img :src="sobreImg" alt="Image" class="img-fluid" />
        </div>

        <div class="col-lg-8">
          <div class="mb-4" data-aos="fade-up" data-aos-delay="0">
            
            <h2 class="heading">
              2025 IUTA WORLD CUP
            </h2>
          </div>
          <div class="mb-4" data-aos="fade-up" data-aos-delay="100">
            <p class="mb-5">
              &#9;Uma das etapas mais emblemáticas do circuito mundial, 
              o Brasil Ultra Tri chega novamente em Búzios, 
              trazendo ao país um evento inesquecível!
            </p>
            <p class="mb-5">
              Com o sucesso das edições anteriores, amplamente elogiadas por atletas ao redor do mundo, retornamos com a mesma excelência para a edição 2025.
            </p>
            <p class="mb-5">
              Novamente, com a maior modalidade de triathlon da América Latina: o DECA ULTRA TRI. Sendo 38 km de natação, 1.800 km de ciclismo e 422 km de corrida — tudo de forma contínua!
            </p>
            <p class="mb-5">
              Além do DECA, outras modalidades já conhecidas pelos nossos atletas estarão disponíveis, como o Quintuplo Contínuo, Triplo Contínuo e Duplo Contínuo.
            </p>
            <p class="mb-5">
              Esta é a única competição no Brasil credenciada pela IUTA e a única prova oficial de Ultra Triathlon na América Latina atualmente, fazendo parte do calendário anual da instituição internacional.
            </p>
            <p>
              Quer saber mais sobre o trabalho e credibilidade da Associação Internacional de Ultra Triathon? 
              <br>
              <a 
              target="_blank" 
              href="https://www.iutasport.com/"
              style="text-decoration: underline;"
              :style="[{ color: themeColor }]" 
              >
                Saiba mais aqui

              </a>
            </p>
          </div>

        </div>

      </div>
    </div>
  </div>
</template>

<style>
p {
  /* text-indent: 40px; */
  margin: 8px 0;
}


</style>