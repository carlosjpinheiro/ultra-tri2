<script setup>
import deca from "../assets/images/mod-deca.png";
import quintuplo from "../assets/images/mod-quintuplo.png";
import triplo from "../assets/images/mod-triplo.png";
import duplo from "../assets/images/mod-duplo.png";
import single from "../assets/images/mod-single.png";
import corridas from "../assets/images/mod-corridas.png";

</script>

<template>
    <div class="untree_co-section" id="modalidades">
        <div class="container">
            
            <div class="row mb-4" data-aos="fade-up" data-aos-delay="0">
                <div class="col-12 text-center">
                    <h2 class="heading text-uppercase negrito">Modalidades e tempos de corte</h2>
                </div>
            </div>

            <div class="row justify-content-between ">

                <div class="card-group d-flex text-center row justify-content-center mx-1">

                    <div class="card col-lg-4">
                        <img class="card-img-top" :src="deca" style="max-width: 40%;" alt="Card image cap">
                        <div class="card-body fundo-claro">
                            <h5 class="card-title text-uppercase negrito">Deca contínuo</h5>
                            <p class="card-text">38 km natação | 1.800 km ciclismo | 422 km corrida</p>
                            <!-- <small class="text-muted">Tempo limite de prova: 324 horas</small> -->
                            <p class="card-text">TEMPO DE CORTE:</p>
                            <p><small class="text-muted">Natação: 26 horas</small></p>
                            <p><small class="text-muted">Natação + T1 + Bike: 180 horas</small></p>
                            <p><small class="text-muted">Total: 336 horas</small></p>
                        </div>
                    </div>

                    <div class="card col-lg-4">
                        <img class="card-img-top" :src="quintuplo" style="max-width: 40%;" alt="Card image cap">
                        <div class="card-body fundo-claro">
                            <h5 class="card-title text-uppercase negrito">Quintuplo contínuo</h5>
                            <p class="card-text">19 km natação | 900 km ciclismo | 211 km corrida</p>
                            <!-- <small class="text-muted">Tempo limite de prova: 144 horas</small> -->
                            <p class="card-text">TEMPO DE CORTE:</p>
                            <p><small class="text-muted">Natação: 12 horas</small></p>
                            <p><small class="text-muted">Natação + T1 + Bike: 86 horas</small></p>
                            <p><small class="text-muted">Total: 144 horas</small></p>
                        </div>
                    </div>

                    <div class="card col-lg-4">
                        <img class="card-img-top" :src="triplo" style="max-width: 40%;" alt="Card image cap">
                        <div class="card-body fundo-claro">
                            <h5 class="card-title text-uppercase negrito">Triplo contínuo</h5>
                            <p class="card-text">11,4 km natação | 540 km ciclismo | 126 km corrida</p>
                            <!-- <small class="text-muted">Tempo limite de prova: 60 horas</small> -->
                            <p class="card-text">TEMPO DE CORTE:</p>
                            <p><small class="text-muted">Natação: 6 horas</small></p>
                            <p><small class="text-muted">Natação + T1 + Bike: 36 horas</small></p>
                            <p><small class="text-muted">Total: 60 horas</small></p>
                        </div>
                    </div>

                    <div class="card col-lg-4">
                        <img class="card-img-top" :src="duplo" style="max-width: 40%;" alt="Card image cap">
                        <div class="card-body fundo-claro">
                            <h5 class="card-title text-uppercase negrito">Duplo contínuo</h5>
                            <p class="card-text">7,6 km natação | 360 km ciclismo | 84 km corrida</p>
                            <!-- <small class="text-muted">Tempo limite de prova: 36 horas</small>                             -->
                            <p class="card-text">TEMPO DE CORTE:</p>
                            <p><small class="text-muted">Natação: 4 horas</small></p>
                            <p><small class="text-muted">Natação + T1 + Bike: 24 horas</small></p>
                            <p><small class="text-muted">Total: 36 horas</small></p>
                        </div>
                    </div>

                    <div class="card col-lg-4">
                        <img class="card-img-top" :src="single" style="max-width: 40%;" alt="Card image cap">
                        <div class="card-body fundo-claro">
                            <h5 class="card-title text-uppercase negrito">Single Triathlon</h5>
                            <p class="card-text">3,8 km natação | 180 km ciclismo | 42 km corrida</p>
                            <!-- <small class="text-muted">Tempo limite de prova: 20 horas</small> -->
                            <p class="card-text">TEMPO DE CORTE:</p>
                            <p><small class="text-muted">Natação: 2,5 horas</small></p>
                            <p><small class="text-muted">Natação + T1 + Bike: 17 horas</small></p>
                            <p><small class="text-muted">Total: 23 horas</small></p>
                        </div>
                    </div>

                    <div class="card col-lg-4">
                        <img class="card-img-top" :src="corridas" style="max-width: 40%;" alt="Card image cap">
                        <div class="card-body fundo-claro">
                            <h5 class="card-title text-uppercase negrito">Corridas</h5>
                            <p class="card-text">
                                5 Maratonas | 5 Dias seguidos
                                <br><small class="text-muted">Tempo limite diário: 7hrs</small>
                                <br>100km
                                <br><small class="text-muted">Tempo limite: 14 hrs</small>

                            </p>                            
                        </div>
                        <div class="card-footer">
                            <small class="text-muted"></small>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</template>
