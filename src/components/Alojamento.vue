<script setup>
import { ref } from 'vue';
import HomeCarousel from './HomeCarousel.vue';
import aloj1 from '../assets/images/aloj1.JPG?url';
import aloj2 from '../assets/images/aloj2.JPG?url';
import aloj3 from '../assets/images/aloj3.jpeg';
import aloj4 from '../assets/images/aloj4.jpeg';
import { contactInfo } from "../data/items";
import { themeColor} from "../data/items";
import { challengeInfo } from "../data/items";


const fotoAtual = ref(0);
const fotos = [aloj1, aloj2, aloj3, aloj4].map((src, index) => ({ src, alt: `Alojamento da prova — foto ${index + 1}` }));
</script>

<template>
    <div class="ultra-page-body page-alojamento" >

        <div class="container " id="alojamento" >
            <div class="row mt-8 mx-1">
                <div class="col-11">


                    <div class="mb-4"  >
                        <p>
                            Os atletas podem optar por usar o alojamento da prova, alugar por conta própria um motorhome ou hospedar-se em hotel ou pousada de
                            sua preferência. Indicamos o <strong>Hotel Aretê</strong> como
                            acomodação mais próxima do local da prova. Atletas
                            possuem 10% desconto utilizando o cupom <strong>{{ challengeInfo.areteCupom }}</strong>.
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
                            <div class="mb-4"  >
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
                            <div class="mb-4"  >
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
                        <p>O pagamento deve ser realizado antecipadamente até o dia 05/04/2027, pois o serviço é fornecido por uma empresa terceirizada.</p>

                        <div class="ultra-alojamento-carousel">
                            <HomeCarousel v-model="fotoAtual" :fotos="fotos" label="Fotos do alojamento da prova" />
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
