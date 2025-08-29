<script setup>
import { VIcon } from "vuetify/lib/components/index.mjs";
import RegulamentoCorridas from "../assets/pdf/RegulamentoCorridas.pdf";
import IUTAWaiver from "../assets/pdf/IUTAWaiver.pdf";
import RegulamentoBrasil2026 from "../assets/pdf/RegulamentoBrasil2026.pdf";



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

                <div class="card-group text-center row mt-4" style="margin: 0 auto;">
                    <div class="card col-lg-12" style="margin-right: 100px !important;">

                        <div >
                            <a :href="RegulamentoCorridas" download>
                                <VIcon
                                    style="font-size: 150px; color: rgba(255, 0, 0, 0.6);"
                                    icon="mdi-file-pdf-box"
                                />
                            </a>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-uppercase">Regulamento das corridas</h5>
                            <p class="card-text">Regulamento das corridas</p>
                        </div>
                    </div>

                    <div class="card col-lg-12">

                        <div >
                            <a :href="RegulamentoBrasil2026" download>
                                <VIcon
                                    style="font-size: 150px; color: rgba(255, 0, 0, 0.6);"
                                    icon="mdi-file-pdf-box"
                                />
                            </a>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-uppercase">Brasil Ultra Tri 2026</h5>
                            <p class="card-text">Documento de conhecimento obrigatório </p>
                            <p class="card-text">para todos participantes</p>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
      
</template>
