<script setup>
import deca from "../assets/images/mod-deca.png";
import quintuplo from "../assets/images/mod-quintuplo.png";
import triplo from "../assets/images/mod-triplo.png";
import duplo from "../assets/images/mod-duplo.png";
import single from "../assets/images/mod-single.png";
import corridas from "../assets/images/mod-corridas.png";
import doubledeca from "../assets/images/mod-doubledeca.png";
import meiotriathlon from "../assets/images/mod-meio-triathlon.png";

const modalidades = [
  // {
  //   img: doubledeca,
  //   titulo: "Double Deca contínuo",
  //   provas: "76 km natação | 3.600 km ciclismo | 844 km corrida",
  //   cortes: [
  //     "Natação: 60 horas",
  //     "Natação + T1 + Bike: 384 horas",
  //     "Total: 672 horas",
  //   ],
  //   ativo: false, // pode controlar se exibe ou não
  // },
  {
    img: deca,
    titulo: "Deca contínuo",
    provas: "38 km natação | 1.800 km ciclismo | 422 km corrida",
    cortes: [
      "Natação: 26 horas",
      "Natação + T1 + Bike: 192 horas",
      "Total: 336 horas",
    ],
    ativo: true,
  },
  {
    img: deca,
    titulo: "Deca um por dia",
    provas: "3,8 km natação | 180 km ciclismo | 42 km corrida",
    cortes: ["Total: 23:30h", "*por dia"],
    ativo: true,
  },
  {
    img: quintuplo,
    titulo: "Quintuplo contínuo",
    provas: "19 km natação | 900 km ciclismo | 211 km corrida",
    cortes: [
      "Natação: 12 horas",
      "Natação + T1 + Bike: 86 horas",
      "Total: 144 horas",
    ],
    ativo: true,
  },
  {
    img: quintuplo,
    titulo: "Quintuplo um por dia",
    provas: "3,8 km natação | 180 km ciclismo | 42 km corrida",
    cortes: [ "Total: 23:30 horas", "*por dia" ],
    ativo: true,
  },
  {
    img: triplo,
    titulo: "Triplo contínuo",
    provas: "11,4 km natação | 540 km ciclismo | 126 km corrida",
    cortes: [
      "Natação: 6 horas",
      "Natação + T1 + Bike: 36 horas",
      "Total: 60 horas",
    ],
    ativo: true,
  },
  {
    img: duplo,
    titulo: "Duplo contínuo",
    provas: "7,6 km natação | 360 km ciclismo | 84 km corrida",
    cortes: [
      "Natação: 4 horas",
      "Natação + T1 + Bike: 24 horas",
      "Total: 36 horas",
    ],
    ativo: true,
  },
  {
    img: duplo,
    titulo: "Duplo um por dia",
    provas: "3,8 km natação | 180 km ciclismo | 42 km corrida",
    cortes: [ "Total: 23:30 horas", "*por dia" ],
    ativo: true,
  },
  {
    img: single,
    titulo: "Single Triathlon",
    provas: "3,8 km natação | 180 km ciclismo | 42 km corrida",
    cortes: [
      "Natação: 2,5 horas",
      "Natação + T1 + Bike: 10 horas",
      "Total: 18 horas",
    ],
    ativo: true,
  },
  {
    img: meiotriathlon,
    titulo: "Meio Triathlon",
    provas: "1,9 km natação | 90 km ciclismo | 21 km corrida",
    cortes: [
      "Natação: 1,5 horas",
      "Natação + T1 + Bike: 5 horas",
      "Total: 8 horas",
    ],
    ativo: true,
  },
  {
    img: corridas,
    titulo: "Corrida",
    provas: "Corrida 100km",
    cortes: [
      "Tempo limite: 14hrs",
    ],
    ativo: true,
  },
  {
    img: corridas,
    titulo: "Corrida",
    provas: "Corrida 24 Horas",
    cortes: [
      "Tempo limite: 24hrs",
    ],
    ativo: true,
  },
    {
    img: corridas,
    titulo: "Corrida",
    provas: "Corrida 12 Horas",
    cortes: [
      "Tempo limite: 12hrs",
    ],
    ativo: true,
  },
    {
    img: corridas,
    titulo: "Corrida",
    provas: "Corrida 06 Horas",
    cortes: [
      "Tempo limite: 06hrs",
    ],
    ativo: true,
  },
    {
    img: corridas,
    titulo: "Corrida",
    provas: "Corrida 03 Horas",
    cortes: [
      "Tempo limite: 03hrs",
    ],
    ativo: true,
  },
];
</script>

<template>
  <div class="untree_co-section" id="modalidades">
    <div class="container">
      <div class="row mb-4" data-aos="fade-up" data-aos-delay="0">
        <div class="col-12 text-center">
          <h2 class="heading text-uppercase negrito">Modalidades e tempos de corte</h2>
        </div>
      </div>

      <div class="row justify-content-between">
        <div class="card-group d-flex text-center row justify-content-center mx-1">
          <div v-for="(modalidade, index) in modalidades" :key="index" class="card col-lg-4">
            <img class="card-img-top" :src="modalidade.img" style="max-width: 40%;" alt="Card image cap" />
            <div class="card-body fundo-claro">
              <h5 class="card-title text-uppercase negrito">{{ modalidade.titulo }}</h5>
              <p class="card-text">{{ modalidade.provas }}</p>
              <p class="card-text">TEMPO DE CORTE:</p>
              <p v-for="(corte, i) in modalidade.cortes" :key="i">
                <small class="text-muted">{{ corte }}</small>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
