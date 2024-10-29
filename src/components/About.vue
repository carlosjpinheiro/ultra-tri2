<script setup>
import { themeColor } from "../data/items";
import iutaLogo from "../assets/images/IUTA_Logo.png";

const heading = "About";
const subHeading = "About Us";
const totalMembers = "50";
const totalTeam = "20";
</script>

<template>
  <div class="untree_co-section" id="about-section">
    <div class="container">
      <div class="row justify-content-between ">

        <div class="col-lg-4 " data-aos="fade-up" data-aos-delay="100">
          <img :src="iutaLogo" alt="Image" class="img-fluid" />
        </div>

        <div class="col-lg-8">
          <div class="mb-4" data-aos="fade-up" data-aos-delay="0">
            <span class="caption" :style="[{ color: themeColor }]">
            Sobre
          </span>
            <h2 class="heading">
              Ultra Triathlon no Brasil  
            </h2>
          </div>
          <div class="mb-4" data-aos="fade-up" data-aos-delay="100">
            <p>
              &#9;Uma das etapas mais emblemáticas do circuito mundial, 
              o Brasil Ultra Tri chega novamente em Búzios, 
              trazendo ao país um evento inesquecível!
            </p>
            <p>
              Com o sucesso das edições anteriores, amplamente elogiadas por atletas ao redor do mundo, retornamos com a mesma excelência para a edição 2025.
            </p>
            <p>
              Novamente, com a maior modalidade de triathlon da América Latina: o DECA ULTRA TRI. Sendo 38 km de natação, 1.800 km de ciclismo e 422 km de corrida — tudo de forma contínua!
            </p>
            <p>
              Além do DECA, outras modalidades já conhecidas pelos nossos atletas estarão disponíveis, como o Quintuplo Contínuo, Triplo Contínuo e Duplo Contínuo.
            </p>
            <p>
              Esta é a única competição no Brasil credenciada pela IUTA e a única prova oficial de Ultra Triathlon na América Latina atualmente, fazendo parte do calendário anual da instituição internacional.
            </p>
            <p>
              Quer saber mais sobre o trabalho e credibilidade da Associação Internacional de Ultra Triathon? 
              <a target="_blank" href="https://www.iutasport.com/">
                Saiba mais aqui

              </a>
            </p>
          </div>
<!-- 
          <div class="row count-numbers">
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="0">
              <span class="counter d-block"
                ><span :data-number="totalMembers">{{ totalMembers }}</span
                ><span>M</span></span
              >
              <span class="caption-2">Members</span>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
              <span class="counter d-block"
                ><span :data-number="totalTeam">{{ totalTeam }}</span
                ><span></span
              ></span>
              <span class="caption-2">Team</span>
            </div>
          </div> -->

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