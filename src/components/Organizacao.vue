<script setup>
import { themeColor } from "../data/items";
import daniel1 from '../assets/images/daniel1.webp'
import jessica1 from '../assets/images/jessica1.png'

const socialDaniel = [
  {
    link: "https://www.instagram.com/ultradanieldeoliveira",
    icon: "icon-instagram",
  },
  {
    link: "https://www.facebook.com/daniel.deoliveira.921",
    icon: "icon-facebook",
  },
  {
    link: "https://www.linkedin.com/in/daniel-de-oliveira-91865a216/",
    icon: "icon-linkedin",
  },
  {
    link: "https://www.youtube.com/@ultradanieldeoliveira9351",
    icon: "icon-youtube",
  },
];

const socialJessica = [
  {
    link: "https://www.instagram.com/jeealba",
    icon: "icon-instagram",
  },
  {
    link: "https://www.linkedin.com/in/jessica-alba-755651160/",
    icon: "icon-linkedin",
  },
];


</script>

<template>

<div class="untree_co-section">
    <div class="container" id="organizacao" style="margin-top: 80px;">

        <div class="row mb-5">
            <div class="col-lg-4 text-center mb-4">
                <img :src="daniel1" alt="Daniel De Oliveira" class="img-fluid rounded-circle" style="max-height: 200px; max-width: 200px;">
            </div>
            <div class="col-lg-8">
                <h2>Daniel de Oliveira</h2>
                <p><strong>Ultra Triatleta Brasileiro</strong></p>
                <p>Daniel é ultra triatleta desde 2011. Já é conhecido nas provas da IUTA, onde disputou em diversos países as provas mais difíceis do mundo.</p>
                <ul class="ml-4">
                    <li><strong>Campeão Mundial - Quintuple Contínuo</strong> - Ano: 2016 | México</li>
                    <li><strong>Vice Campeão Mundial - Deca Contínuo</strong> - Ano: 2017 | México</li>
                    <li><strong>Recordista Panamericano - Double Deca Contínuo</strong> - Ano: 2019 | México - 3º homem mais resistente do mundo</li>
                    <li><strong>Recordista Panamericano - Quadruplo Um por Dia</strong> - Ano: 2021 | México</li>
                </ul>
                <p>Hoje, além de atleta, Daniel é palestrante, autor de livro, mentor e organizador de eventos esportivos.</p>
                <p>Acompanhe pelas suas redes sociais:

                    <div class="widget">
                        <!-- <h3>{{ connectHeading }}</h3> -->
                        <ul class="list-unstyled social d-flex">
    
                            <li v-for="item in socialDaniel" style="margin-right: 4px; font-size: 28px;" class="mr-4">
                                <a :href="item.link" target="_blank">
                                    <span :class="item.icon" 
                                    :style="[
                                        { color: themeColor }
                                    ]" 
                                />
                                </a>
                            </li>
    
                        </ul>
                    </div>
                </p>
                
            </div>
            
        </div>

        <VDivider/>

        <!-- Seção Jessica Alba -->
        <div class="row">
            <div class="col-lg-4 text-center mb-4">
                <img :src="jessica1" alt="Jessica Alba" class="img-fluid rounded-circle" style="max-height: 200px; max-width: 200px;">
            </div>
            <div class="col-lg-8">
                <h2>Jessica Alba</h2>
                <p><strong>Direção e Planejamento</strong></p>
                <p>Formada em administração e atuando na área publicitária há 10 anos, Jessica é responsável pela criação do Brasil Ultra Tri.</p>
                <ul class="ml-4">
                    <li>Criou toda a identidade visual do evento, seguindo as cores e tradições do nosso país, transmitindo uma imagem única e alegre do que queremos mostrar ao mundo.</li>
                    <li>Responsável pelo planejamento estratégico e logístico do evento, além do contato com fornecedores e parceiros.</li>
                    <li>Responsável pela área administrativa e financeira.</li>
                </ul>
                <p>Siga nas redes sociais:

                    <div class="widget">
                        <ul class="list-unstyled social d-flex">
    
                            <li v-for="item in socialJessica" style="margin-right: 4px; font-size: 28px;" class="mr-4">
                                <a :href="item.link" target="_blank">
                                    <span :class="item.icon" 
                                    :style="[
                                        { color: themeColor }
                                    ]" 
                                    />
                                </a>
                            </li>
    
                        </ul>
                    </div>

                </p>
            </div>
            
        </div>

    </div>
</div>


<!-- 
    <div class="untree_co-section" >
        <div class="container" id="organizacao" style="margin-top: 80px;">
        
            <div class="row mb-5">
            <div class="col-md-4 text-center">
                <img :src="daniel1" alt="Daniel De Oliveira" class="img-fluid rounded-circle" style="max-height: 200px; max-width: 200px;"> 
            </div>
            <div class="col-md-8">
                <h2>Daniel de Oliveira</h2>
                <p><strong>Ultra Triatleta Brasileiro</strong></p>
                <p>Daniel é ultra triatleta desde 2011. Já é conhecido nas provas da IUTA, onde disputou em diversos países as provas mais difíceis do mundo.</p>
                <ul class="ml-4">
                    <li><strong>Campeão Mundial - Quintuple Contínuo</strong> - Ano: 2016 | México</li>
                    <li><strong>Vice Campeão Mundial - Deca Contínuo</strong> - Ano: 2017 | México</li>
                    <li><strong>Recordista Panamericano - Double Deca Contínuo</strong> - Ano: 2019 | México - 3º homem mais resistente do mundo</li>
                    <li><strong>Recordista Panamericano - Quadruplo Um por Dia</strong> - Ano: 2021 | México</li>
                </ul>
                <p>Hoje, além de atleta, Daniel é palestrante, autor de livro, mentor e organizador de eventos esportivos.</p>
                <div class="social-links">
                    <p>Acompanhe pelas suas redes sociais:</p>
                    <a href="https://www.instagram.com" target="_blank" class="fab fa-instagram">Instagram</a>
                    <a href="https://www.facebook.com" target="_blank" class="fab fa-facebook">Facebook</a>
                    <a href="https://www.linkedin.com" target="_blank" class="fab fa-linkedin">LinkedIn</a>
                    <a href="https://www.youtube.com" target="_blank" class="fab fa-youtube">YouTube</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 text-center">
                <img :src="jessica1" alt="Jessica Alba" class="img-fluid rounded-circle" style="max-height: 200px; max-width: 200px;">
            </div>
            <div class="col-md-8">
                <h2>Jessica Alba</h2>
                <p><strong>Direção e Planejamento</strong></p>
                <p>Formada em administração e atuando na área publicitária há 10 anos, Jessica é responsável pela criação do Brasil Ultra Tri.</p>
                <ul class="ml-4">
                    <li>Criou toda a identidade visual do evento, seguindo as cores e tradições do nosso país, transmitindo uma imagem única e alegre do que queremos mostrar ao mundo.</li>
                    <li>Responsável pelo planejamento estratégico e logístico do evento, além do contato com fornecedores e parceiros.</li>
                    <li>Responsável pela área administrativa e financeira.</li>
                </ul>
                <div class="social-links">
                    <p>Siga nas redes sociais:</p>
                    <a href="https://www.instagram.com" target="_blank" class="fab fa-instagram">Instagram</a>
                    <a href="https://www.linkedin.com" target="_blank" class="fab fa-linkedin">LinkedIn</a>
                </div>
            </div>
        </div>



        </div>
    </div>     -->

</template>
