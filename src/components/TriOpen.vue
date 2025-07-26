<script setup>
import { themeColor } from "../data/items";

</script>

<template>

  <div class="untree_co-section">

    <div class="container" style="margin-top: 80px;">

      <div class="mt-12 my-8">
        <div class="col-lg-12 my-2">
          <h1 style="text-align: center;" class="text-uppercase negrito">
            BRASIL TRI OPEN 2025
          </h1>
          <h1 style="text-align: center;" class="text-uppercase negrito">
            O PREVIEW DO BRASIL ULTRA TRI
          </h1>
        </div>
      </div>

      <div class="my-4" data-aos="fade-up" data-aos-delay="100">

        <h2 class="my-4">BRASIL TRI OPEN – 18 e 19 de Outubro</h2>
        <h3 class="my-4">No Clube Aretê - Búzios</h3>

        <p class="my-4 justificado">
          Apresentamos o <strong>Brasil Tri Open</strong>, um evento pensado para receber atletas amadores e apaixonados pelo triathlon,
          oferecendo a oportunidade de vivenciar uma experiência de alto nível em um dos locais mais belos e bem estruturados do país.
        </p>

        <p class="my-4 justificado">
          Com as distâncias de <strong>Meio Triathlon</strong> e <strong>Triathlon Completo</strong>, o Brasil Tri Open é ideal para quem está dando os
          primeiros passos nas provas de longa duração ou deseja se preparar para desafios ainda maiores — como o <strong>Brasil Ultra Tri</strong>,
          que irá acontecer em maio de 2026.
        </p>

        <p class="my-4 justificado">
          Nosso objetivo é ampliar o acesso ao triathlon de endurance e fortalecer essa modalidade esportiva no Brasil.
          Através de um circuito de qualidade, estrutura completa e ambiente inspirador, queremos proporcionar uma experiência marcante,
          que estimule a evolução e o comprometimento dos atletas!
        </p>

        <p class="my-4 justificado">
          Seja você um <em>estreante</em> ou alguém em busca de novos limites, o <strong> Brasil Tri Open é o seu ponto de partida.</strong>
          
        </p>

        <p class="my-4 justificado">
            Prepare-se para viver o triathlon em sua essência!
        </p>

        <div class="row mb-6 mt-6" data-aos="fade-up" data-aos-delay="0">
          <div class="col-12 text-start">
              <h2 class="heading text-uppercase negrito">LOTES DISPONÍVEIS:</h2>
          </div>
        </div>                

        <div class="row justify-content-between g-4 mx-1">
            <div class="col-lg-4 col-md-6 col-12 mb-2">

                <div class="card fundo-claro borda-preta h-100 " data-aos="fade-up" data-aos-delay="100">
                    <div class="card-body pt-2">
                        <h4 class="card-title text-center">Primeiro lote (promocional)</h4>
                        <p class="card-text text-center">
                          ENCERRADO!
                        </p>
                        <ul class="ml-6 float-left links w-100">
                          <li><span class="font-weight-bold">Triathlon Completo</span> | $450,00</li>
                          <li><span class="font-weight-bold">Meio Triathlon</span> | $300,00</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12 mb-2">
                <div class="card borda-preta fundo-claro h-100" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-body pt-2">
                        <h4 class="card-title text-center">Segundo lote</h4>
                        <p class="card-text text-center">
                            21/Julho até 31/Agosto
                        </p>
                        <ul class="ml-6 float-left links w-100">
                          <li><span class="font-weight-bold">Triathlon Completo</span> | $500,00</li>
                          <li><span class="font-weight-bold">Meio Triathlon</span> | $350,00</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12 ">
                <div class="card borda-preta fundo-claro h-100" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-body pt-2">
                        <h4 class="card-title text-center">Terceiro lote</h4>
                        <p class="card-text text-center">
                            01/Setembro até 30/Setembro
                        </p>
                        <ul class="ml-6 float-left links w-100">
                          <li><span class="font-weight-bold">Triathlon Completo</span> | $550,00</li>
                          <li><span class="font-weight-bold">Meio Triathlon</span> | $400,00</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <small class="ml-6">*Dólares americanos, padrão circuito mundial</small>

        <div class="h5 mt-4">
          <p >Formas de pagamento:</p>
          <p>Transferência à vista, cartão de crédito e PIX.</p>
        </div>


        <p style="text-align: center;" data-aos="fade-up" data-aos-delay="200">
                  
            <RouterLink 
            :style="[
                { color: themeColor }, 
                { borderColor: themeColor }]"
            class="btn smoothscroll pricing "
            :to="{ name: 'inscricaotriopen',  }" 
            >
            <span style="font-size: 14px;">
                Inscreva-se
            </span>
            </RouterLink>
        </p>

      </div>

    </div>
  </div>

</template>

<style>
.justificado {
  text-align: justify;
}
</style>
