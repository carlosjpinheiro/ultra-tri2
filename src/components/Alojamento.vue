<script setup>
import { contactInfo } from "../data/items";
import { themeColor} from "../data/items";
import alojamento1 from "../assets/images/alojamento1.webp";
import alojamento2 from "../assets/images/alojamento2.webp";
import alojamento3 from "../assets/images/alojamento3.webp";

</script>

<template>
    <div class="untree_co-section" >
        
        <div class="container" id="alojamento" style="margin-top: 80px;">
            <div class="row mt-8">
                <div class="col-lg-8">
                    <div class="mb-4" data-aos="fade-up" data-aos-delay="0">
                        <h2 class="heading">
                            Alojamento na prova
                        </h2>
                    </div>

                    <div class="mb-4" data-aos="fade-up" data-aos-delay="100">
                        <p>
                            Os atletas podem optar por usar o alojamento da prova, alugar por conta própria um motorhome ou escolher o hotel de sua preferência para hospedagem durante o evento.
                        </p>
                        <p>
                            Para aqueles que desejarem, estarão disponíveis para locação barracas iglús equipadas com colchão inflável, oferecendo um local confortável para descanso conforme o cronograma de pausas. Os membros da equipe de apoio (staff) também poderão utilizá-las.
                        </p>
                        <p>
                            <div class="mb-4" data-aos="fade-up" data-aos-delay="0">
                                <h4 class="">
                                    Informações importantes:
                                </h4>
                            </div>
                            <ul class="ml-4 float-left links w-100">
                                <li>Tanto os atletas quanto os membros do staff podem alugar quantas barracas forem necessárias.</li>
                                <li>É permitido que os atletas/staff tragam suas próprias barracas, sem custo adicional.</li>
                                <li>Não é obrigatório o uso da barraca: se dois atletas quiserem dividir e revezar o uso de uma barraca alugada, isso é permitido.</li>
                                <li>O atleta pode ir para o hotel durante a prova, avisando a orgaanização sobre sua ausência.</li>
                                
                            </ul>
                        </p>
                        <p>
                            <div class="mb-4" data-aos="fade-up" data-aos-delay="0">
                                <h4 class="">
                                    Valores - Kit Barraca + Colchão de Casal:
                                </h4>
                            </div>
                            <ul class="ml-4 float-left links w-100">
                                <li>Duplo Contínuo: $40 (R$ 200) – disponível para 3 dias de uso</li>
                                <li>Triplo Contínuo: $75 (R$ 380) – disponível para 4 dias de uso</li>
                                <li>Quíntuplo Contínuo: $135 (R$ 680) – disponível para 6 dias de uso</li>
                                <li>Deca Contínuo: $170 (R$ 862) – disponível para 14 dias de uso</li>                                
                            </ul>
                        </p>
                        <p>O pagamento deve ser realizado antecipadamente até o dia 05/04/2025, pois o serviço é fornecido por uma empresa terceirizada.</p>
                        


                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="card">
                                    <img class="card-img-top" :src="alojamento2" alt="Alojamento 2" />
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="card">
                                    <img class="card-img-top" :src="alojamento1" alt="Alojamento 1" />
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="card">
                                    <img class="card-img-top" :src="alojamento3" alt="Alojamento 3" />
                                </div>
                            </div>
                        </div>

                        <br>

                        <h5 class="text-center">
                            Ficou com dúvida sobre esse tema?
                            <a :href="'mailto:' + contactInfo.email">
                                <span 
                                    :style="[
                                        { color: themeColor },
                                    ]" 
                                >
                                Pode nos acionar!
                                </span>
                            </a>
                        </h5>

                    </div>

                </div>
            </div>
        </div>

    </div>      
</template>

<style>
#alojamento .card-img-top{
    height: 35vh;
}

</style>