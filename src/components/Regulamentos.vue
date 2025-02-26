<script setup>
import { VIcon } from "vuetify/lib/components/index.mjs";
import RegulamentoGeral from "../assets/pdf/RegulamentoGeral.pdf";
import RegulamentoCorridas from "../assets/pdf/RegulamentoCorridas.pdf";
import IUTAWaiver from "../assets/pdf/IUTAWaiver.pdf";

</script>

<template>
    <div class="untree_co-section" >

        <div class="container" style="margin-top: 80px;">

            <div class="row mt-8 mx-1">
                <div class="col-lg-12">
                    <h2 class="heading text-uppercase negrito">
                        Regulamentos - BRASIL ULTRA TRI
                    </h2>

                </div>
            </div>
                    
            <div class="row mx-1" data-aos="fade-up" data-aos-delay="100">

                <div class="card-group text-center row mt-4">
                    <div class="card col-lg-4">

                        <div >
                            <a :href="RegulamentoGeral" download>
                                <VIcon
                                    style="font-size: 150px; color: rgba(255, 0, 0, 0.6);"
                                    icon="mdi-file-pdf-box"
                                />
                            </a>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-uppercase">Regulamento geral</h5>
                            <p class="card-text">Documento de conhecimento obrigatório para todos participantes</p>
                        </div>
                    </div>

                    <div class="card col-lg-4">
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
                            <p class="card-text">Regras para as modalidades de corrida</p>
                            
                        </div>
                    </div>

                    <div class="card col-lg-4">
                        <div >
                            <a :href="IUTAWaiver" download>
                                <VIcon
                                    style="font-size: 150px; color: rgba(255, 0, 0, 0.6);"
                                    icon="mdi-file-pdf-box"
                                />

                            </a>

                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-uppercase">IUTA Waiver</h5>
                            <p class="card-text">Documento obrigatório de assinatura dos atletas do ultra triathlon</p>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      
</template>
