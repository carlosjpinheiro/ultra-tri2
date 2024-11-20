<script setup>
import ultraTriImg from "../assets/images/LOGOS_ULTRA_TRI_sem_bixo.png";

</script>

<template>
    <div class="untree_co-section" id="modalidades">
        <div class="container">
            
            <div class="row mb-4" data-aos="fade-up" data-aos-delay="0">
                <div class="col-12 text-center">
                    <h2 class="heading">Modalidades</h2>
                </div>
            </div>

            <div class="row justify-content-between ">


                <div class="card-group d-flex text-center row justify-content-center ">

                    <div class="card col-lg-4">
                        <img class="card-img-top" :src="ultraTriImg" style="max-width: 40%;" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Deca contínuo</h5>
                            <p class="card-text">38 km natação | 1.800 km ciclismo | 422 km corrida</p>
                            
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Tempo limite de prova: 324 horas</small>
                        </div>
                    </div>

                    <div class="card col-lg-4">
                        <img class="card-img-top" :src="ultraTriImg" style="max-width: 40%;" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Quintuplo contínuo</h5>
                            <p class="card-text">19 km natação | 900 km ciclismo | 211 km corrida</p>
                            
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Tempo limite de prova: 144 horas</small>
                        </div>
                    </div>

                    <div class="card col-lg-4">
                        <img class="card-img-top" :src="ultraTriImg" style="max-width: 40%;" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Duplo contínuo</h5>
                            <p class="card-text">7,6 km natação | 360 km ciclismo | 84 km corrida</p>
                            
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Tempo limite de prova: 36 horas</small>
                        </div>
                    </div>

                    <div class="card col-lg-4">
                        <img class="card-img-top" :src="ultraTriImg" style="max-width: 40%;" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Triathlon single</h5>
                            <p class="card-text">3,8 km natação | 180 km ciclismo | 42 km corrida</p>
                            
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Tempo limite de prova: 20 horas</small>
                        </div>
                    </div>

                    <div class="card col-lg-4">
                        <img class="card-img-top" :src="ultraTriImg" style="max-width: 40%;" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Corridas</h5>
                            <p class="card-text">
                                5 Maratonas | 5 Dias seguidos
                                <br><small class="text-muted">Tempo limite diário: 7hrs</small>
                                <br>100km
                                <br><small class="text-muted">Tempo limite: 14 hrs</small>
                                <br>Maratona

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
