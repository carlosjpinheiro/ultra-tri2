<script setup>
import { VIcon } from "vuetify/lib/components/index.mjs";
import RegulamentoGeral from "../assets/pdf/RegulamentoGeral.pdf";
import RegulamentoCorridas from "../assets/pdf/RegulamentoCorridas.pdf";
import IUTAWaiver from "../assets/pdf/IUTAWaiver.pdf";
import RegulamentoTriOpen2025 from "../assets/pdf/RegulamentoTriOpen2025.pdf";



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
                    <div class="card col-lg-12">

                        <div >
                            <a :href="RegulamentoTriOpen2025" download>
                                <VIcon
                                    style="font-size: 150px; color: rgba(255, 0, 0, 0.6);"
                                    icon="mdi-file-pdf-box"
                                />
                            </a>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-uppercase">Brasil Tri Open 2025 - Outubro</h5>
                            <p class="card-text">Documento de conhecimento obrigatório para todos participantes</p>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
      
</template>
