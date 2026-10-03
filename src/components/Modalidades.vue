<script setup>
import { modalidadesAtivas } from "../data/modalidades";
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
          <div v-for="modalidade in modalidadesAtivas" :key="modalidade.id" class="card col-lg-4">
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
