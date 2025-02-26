<script setup>
import clubePiscina from '../assets/images/clube_piscina.jpg'
import hotel1 from '../assets/images/hotel_1.jpg'


</script>

<template>

    <div class="untree_co-section" >
        <div class="container" id="comochegar" style="margin-top: 80px;">
        
            <div class="row mt-8 mx-1 text-justify">
                <div class="col-lg-10">
                    <div class="mb-4" data-aos="fade-up" data-aos-delay="0">
                        <h2 class="heading text-uppercase negrito">
                            Como chegar?
                        </h2>
                    </div>

                        <div class="row mb-5">

                            
                            <div class="col-lg-6 ">
                                <h3 >Clube</h3>
                                <p>
                                    O <strong>Clube Aretê Búzios</strong> está localizado na região da Praia Rasa em Búzios. A cidade é bem diferente da agitada capital carioca, Búzios é conhecida por suas belas praias e é um dos principais destinos dos turistas que buscam tranquilidade e contato com a natureza.
                                </p>
                                <p>
                                    O Clube Esportivo Aretê fica a aproximadamente 170km de distância do aeroporto Santos Dumont (RJ).
                                </p>
                            </div>
                            <div class="col-lg-6">                                                
                                
                                <img :src="clubePiscina" alt="Clube Aretê Búzios" class="img-fluid rounded">
                            </div>
                        </div>

                        <!-- Segunda seção de conteúdo: opções de transporte -->
                        <div class="row mb-5">
                            <div class="col-12">
                                <h3>Opções de Transporte</h3>
                                <p>Para chegar até o local da prova, existem duas opções partindo do Rio de Janeiro:</p>
                            </div>
                            
                            <ul>
                                <li class="ml-8">
                                    <div class="">
                                        <h4 class="text-left">Alugando um Carro</h4>
                                        <p>Ao redor dos principais aeroportos do Rio de Janeiro existem várias empresas de aluguel de carro. A viagem até o local da prova leva em média 2 horas. Há pedágio pelo caminho.</p>
                                    </div>

                                </li>

                                <li class="ml-8">
                                    <div class="">
                                        <h4 class="text-left">Contratação de Transfer/Translado</h4>
                                        <p>Existem diversas empresas que realizam o translado do Aeroporto até Búzios e de Búzios até o aeroporto, que você pode contratar com antecedência. É importante confirmar com a empresa se todo seu equipamento (mala-bike, malas) cabe no ônibus ou van.</p>
                                        <p>Eles possuem diversos horários de acordo com o horário do seu vôo. A viagem até o local da prova leva em média 3:30h, com pausa no caminho para lanche. O horário pode variar de uma empresa para outra. Indicamos a empresa <strong>INN Búzios</strong>, que realizou todo transporte da primeira edição.</p>
                                    </div>

                                </li>
                            </ul>
                        </div>



                        <div class="row mb-5">
                            <div class="col-lg-6">
                                <h3 >Hotel</h3>
                                <p>
                                    O <strong>Hotel Aretê Búzios</strong> está localizado dentro do complexo Aretê, onde será realizada a competição. É um hotel incrível e completo para o atleta ter a melhor experiência possível de hospedagem. Como somos parceiros neste evento, os participantes do Brasil Ultra Tri contam com um pacote diferenciado e promocional para hospedagem durante os dias da competição! Durante todas as manhãs, nossa equipe irá buscar os atletas que estarão hospedados no hotel Aretê.
                                </p>
                            </div>
                            <div class="col-lg-6">
                                <img :src="hotel1" alt="Hotel Aretê Búzios" class="img-fluid rounded">
                            </div>
                        </div>

                        <!-- Desconto e como reservar -->
                        <div class="row">
                            <div class="col-12">
                                <h3>10% OFF na reserva</h3>
                                <p>
                                    Para garantir o seu desconto de 10%, faça a reserva diretamente pelo site oficial do Hotel Aretê utilizando o cupom de desconto: <strong>BRASILULTRA</strong>, ou reserve através do e-mail <strong>reservas@hotelarete.com.br</strong>, identificando-se como participante da competição.
                                </p>
                                <p>
                                    ** Verifique com o Hotel o horário que será servido o café da manhã diariamente para que você possa chegar em tempo na prova!
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <ul>

                                    <li class="ml-4">
                                        <div class="">
                                            <h4>Observação</h4>
                                            <p>As reservas alteram de valor conforme a lotação de hospedagem. O ideal é efetuar a reserva o quanto antes enquanto a demanda é baixa.</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Conheça o Hotel -->
                        <div class="row">
                            <div class="col">
                                <a href="https://www.hotelarete.com.br/" target="_blank" class="btn ml-n8">
                                    <h4>Conheça o hotel</h4>
                                </a>
                            </div>
                        </div>




                </div>
            </div>
        </div>

    </div>    

</template>

