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
          Com as distâncias de <strong>Meio Iron (70.3)</strong> e <strong>Iron Full</strong>, o Brasil Tri Open é ideal para quem está dando os
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
