<script setup>
import { contactInfo } from "../data/items";
import { themeColor} from "../data/items";

</script>

<template>
    <div class="untree_co-section" >
        
        <div class="container">
            <div class="row justify-content-between mt-8">

                <div class="col-lg-8">
                    <div class="mb-4" data-aos="fade-up" data-aos-delay="0">
                        <h2 class="heading">
                            Cancelamento da prova  
                        </h2>
                    </div>

                    <div class="mb-4" data-aos="fade-up" data-aos-delay="100">
                        <p>
                            Em caso de alteração da data do evento, a inscrição será válida para a nova data. O atleta poderá utilizar o mesmo comprovante ou ticket para entrar no clube e participar normalmente do evento. Caso o atleta prefira não participar na nova data definida, o valor da sua inscrição será devolvido de forma integral ao participante.
                        </p>
                        <p>
                            Em caso de cancelamento do evento, o valor será devolvido de forma integral ao atleta no período de até 10 dias após o aviso.
                        </p>
                        <p>
                            Em caso de cancelamento por parte do atleta, podemos prosseguir de três formas diferentes:
                            <ul class="ml-4 float-left links w-100">
                                <li>Ressarcimento de 50% do valor, para aqueles que desistirem com no máximo 60 dias antes da prova. O valor será reembolsado até 30 dias após a realização do evento.</li>
                                <li>Utilização da inscrição para o próximo ano.</li>
                                <li>Alteração de atleta. O atleta pode ‘vender’ sua inscrição para um amigo ou outra pessoa participar em seu lugar. </li>
                                            
                            </ul>
                        </p>
                        <p>O valor integral não será ressarcido. E não será devolvido valores para aqueles que cancelarem com data inferior a 60 dias antes da prova.</p>

                    </div>

                    <div class="mb-4" data-aos="fade-up" data-aos-delay="0">
                        <h4 class="">
                            Troca de modalidade
                        </h4>
                    </div>

                    <div class="mb-4" data-aos="fade-up" data-aos-delay="100">
                        <p>
                            Se o atleta efetuou a inscrição em uma modalidade e posteriormente queira trocar para uma diferente, ele poderá fazer entrando em contato com a organização pelo e-mail: {{ contactInfo.email  }}. A organização irá verificar a disponibilidade de vagas na modalidade escolhida e alinhar a nova forma de pagamento. A organização tem o prazo de 3 dias para retornar.
                        </p>
                    </div>

                    <div class="mb-4" data-aos="fade-up" data-aos-delay="0">
                        <h4 class="">
                            Da hospedagem
                        </h4>
                    </div>

                    <div class="mb-4" data-aos="fade-up" data-aos-delay="100">
                        <p>
                            A reserva feita com o Hotel Aretê Búzios é feita diretamente com o hotel. Em caso de cancelamento por parte do cliente, o mesmo deve verficar a Política de Cancelamento do próprio hotel. Em caso de cancelamento ou alteração de data por parte do Brasil Ultra Tri, o atleta não será prejudicado ou pagará qualquer tipo de multa. 
                        </p>
                    </div>

                    <h5 class="text-center">
                        Para dúvidas em relação a cancelamento de inscrição, troca de modalidade ou política de devolução entre em 
                        <a :href="'mailto:' + contactInfo.email"
                  ><span 
                  :style="[
                  { color: themeColor },
                  ]" 
                  >
                      contato conosco!

                  </span></a>
                    </h5>

                </div>
            </div>
        </div>

    </div>      
</template>

<style>
</style>