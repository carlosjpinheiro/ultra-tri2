<script setup>
import { VIcon } from "vuetify/lib/components/index.mjs";
import RegulamentoCorridas from "../assets/pdf/RegulamentoCorridas.pdf";
import IUTAWaiver from "../assets/pdf/IUTAWaiver.pdf";
import RegulamentoGeral from "../assets/pdf/RegulamentoGeral.pdf";
import RegulamentoCiclismos from "../assets/pdf/RegulamentoCiclismos.pdf";


</script>

<template>
    <div class="ultra-page-body page-regulamentos" >

        <div class="container" >



            <div class="row mx-1"  >

                <div class="regulamentos-grid text-center mt-4">
                    <a class="card regulamento-download" :href="RegulamentoCorridas" download>

                                <VIcon
                                    class="ultra-pdf-icon"
                                    icon="mdi-file-pdf-box"
                                />

                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-uppercase">Corridas</h5>
                            <p class="card-text">Regulamento das corridas</p>
                        </div>
                    </a>

                    <a class="card regulamento-download" :href="RegulamentoCiclismos" download>

                                <VIcon
                                    class="ultra-pdf-icon"
                                    icon="mdi-file-pdf-box"
                                />

                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-uppercase">Ciclismos</h5>
                            <p class="card-text">Regulamento dos ciclismos</p>
                        </div>
                    </a>

                    <a class="card regulamento-download" :href="RegulamentoGeral" download>

                                <VIcon
                                    class="ultra-pdf-icon"
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
