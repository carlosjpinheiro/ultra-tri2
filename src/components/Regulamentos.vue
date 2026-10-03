<script setup>
import { VIcon } from "vuetify/lib/components/index.mjs";
import RegulamentoCorridas from "../assets/pdf/RegulamentoCorridas.pdf";
import IUTAWaiver from "../assets/pdf/IUTAWaiver.pdf";
import RegulamentoGeral from "../assets/pdf/RegulamentoGeral.pdf";
import RegulamentoCiclismos from "../assets/pdf/RegulamentoCiclismos.pdf";


</script>

<template>
    <div class="untree_co-section" >

        <div class="container" style="margin-top: 80px;">

            <div class="row mt-8 mx-1" >
                <div class="col-lg-12" style="margin: 0 auto;">
                    <h2 class="heading text-uppercase negrito">
                        Regulamentos - BRASIL ULTRA TRI
                    </h2>

                </div>
            </div>

            <div class="row mx-1" data-aos="fade-up" data-aos-delay="100">

                <div class="regulamentos-grid text-center mt-4">
                    <a class="card regulamento-download" :href="RegulamentoCorridas" download>

                                <VIcon
                                    style="font-size: 150px; color: rgba(255, 0, 0, 0.6);"
                                    icon="mdi-file-pdf-box"
                                />

                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-uppercase">Corridas</h5>
                            <p class="card-text">Regulamento das corridas</p>
                        </div>
                    </a>

                    <a class="card regulamento-download" :href="RegulamentoCiclismos" download>

                                <VIcon
                                    style="font-size: 150px; color: rgba(255, 0, 0, 0.6);"
                                    icon="mdi-file-pdf-box"
                                />

                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-uppercase">Ciclismos</h5>
                            <p class="card-text">Regulamento dos ciclismos</p>
                        </div>
                    </a>

                    <a class="card regulamento-download" :href="RegulamentoGeral" download>

                                <VIcon
                                    style="font-size: 150px; color: rgba(255, 0, 0, 0.6);"
                                    icon="mdi-file-pdf-box"
                                />

                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-uppercase">Brasil Ultra Tri 2027</h5>
                            <p class="card-text">Regulamento geral Brasil Ultra Tri</p>
                        </div>
                    </a>


                </div>
            </div>
        </div>
    </div>

</template>

<style scoped>
.regulamentos-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 24px;
    width: 100%;
}
.regulamento-download {
    align-items: center;
    padding: 24px 16px;
    border: 2px solid #fcb603;
    border-radius: 16px;
    color: inherit;
    text-decoration: none;
    transition: background-color 0.2s, box-shadow 0.2s;
}
.regulamento-download:hover {
    background-color: #fcb60322;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
}
.regulamento-download:focus-visible {
    outline: 3px solid #222;
    outline-offset: 4px;
}
.regulamento-download .card-body {
    width: 100%;
    padding: 20px 0 0;
    overflow-wrap: anywhere;
}
@media (max-width: 991px) {
    .regulamentos-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 575px) {
    .regulamentos-grid { grid-template-columns: minmax(0, 1fr); gap: 20px; }
}
</style>
