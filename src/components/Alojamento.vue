<script setup>
import { contactInfo } from "../data/items";
import { themeColor} from "../data/items";
import alojamento1 from "../assets/images/tenda_aluguel.webp";
import alojamento2 from "../assets/images/alojamento2.webp";
import alojamento3 from "../assets/images/alojamento3.webp";

</script>

<template>
    <div class="untree_co-section" >
        
        <div class="container " id="alojamento" style="margin-top: 80px;">
            <div class="row mt-8 mx-1">
                <div class="col-11">
                    <div class="mb-4" data-aos="fade-up" data-aos-delay="0">
                        <h2 class="heading text-uppercase negrito">
                            Alojamento da prova
                        </h2>
                    </div>

                    <div class="mb-4" data-aos="fade-up" data-aos-delay="100">
                        <p>
                            Os atletas podem optar por usar o alojamento da prova, alugar por conta própria um motorhome ou hospedar-se em hotel ou pousada de
                            sua preferência. Indicamos o <strong>Hotel Aretê</strong> como
                            acomodação mais próxima do local da prova. Atletas
                            possuem 10% desconto utilizando o cupom <strong>brasilultra25</strong>.
                            Reservas podem ser feitas através do e-mail:
                            <a :href="'mailto:reservas@hotelarete.com.br'" style="color: black;">
                                <span>reservas@hotelarete.com.br</span>
                            </a>.
                        </p>
                        <p>
                            Para aqueles que desejarem, estarão disponíveis para locação tendas no formato 3x3 com fechamento lateral (imagem ilustrada
abaixo) equipadas com colchão inflável de casal, 1 mesa e 2 cadeiras, oferecendo um local confortável para descanso conforme o
cronograma de pausas de cada atleta
                        </p>
                        <p>
                            <div class="mb-4" data-aos="fade-up" data-aos-delay="0">
                                <h4 class="">
                                    Informações importantes:
                                </h4>
                            </div>
                            <ul class="ml-4 float-left links w-100">
                                <li>Se o atleta preferir, pode levar sua própria barraca ou tenda, que deverá ser montada/instalada somente na área de camping
                                    sinalizada pela organização. A área de camping será ao redor do lago principal, ao lado da pista de corrida.</li>
                                <li>O atleta pode ir para o hotel durante a prova, avisando a organização sobre sua ausência.
                                </li>
                            </ul>
                        </p>
                        <p>
                            <div class="mb-4" data-aos="fade-up" data-aos-delay="0">
                                <h4 class="">
                                    Valores de locação:
                                </h4>
                            </div>
                            <ul class="ml-4 float-left links w-100">
                                <li>Duplo Contínuo: R$400,00</li>
                                <li>Triplo Contínuo: R$600,00</li>
                                <li>Quíntuplo Contínuo: R$900,00</li>
                                <li>Deca Contínuo: R$1.300,00</li>                                
                            </ul>
                        </p>
                        <p>O pagamento deve ser realizado antecipadamente até o dia 05/04/2025, pois o serviço é fornecido por uma empresa terceirizada.</p>
                        
                        <div class="row">
                            <!-- <div class="col-12 col-md-4">
                                <div class="card">
                                    <img class="card-img-top" :src="alojamento2" alt="Alojamento 2" />
                                </div>
                            </div> -->
                            <div class="col-12 col-md-4">
                                <div class="card text-center">
                                    <img class="card-img-top" :src="alojamento1" alt="Alojamento 1" />
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="card text-center">
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