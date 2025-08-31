<script setup>
import tabela01 from "../assets/images/resultados-2025/01.jpg";
import tabela02 from "../assets/images/resultados-2025/02.jpg";
import tabela03 from "../assets/images/resultados-2025/03.jpg";
import tabela04 from "../assets/images/resultados-2025/04.jpg";
import tabela05 from "../assets/images/resultados-2025/05.jpg";
import tabela06 from "../assets/images/resultados-2025/06.jpg";
import tabela07 from "../assets/images/resultados-2025/07.jpg";

const tabelas = [
  tabela01,
  tabela02,
  tabela03,
  tabela04,
  tabela05,
  tabela06,
  tabela07,
]

</script>

<template>
    

    <div class="untree_co-section" >
        <div class="container" id="comochegar" style="margin-top: 80px;">
        
            <div class="row mt-8 mx-1 text-justify">
                <div class="col-12 text-center">
                    <div class="mb-4" data-aos="fade-up" data-aos-delay="0">
                        <h2 class="heading text-uppercase negrito">
                            RESULTADOS POR MODALIDADE
                        </h2>
                    </div>
                </div>
            </div>

            <div v-for="tabela in tabelas">

                    <div class="row mt-2 text-center">
                        <div class="col-12"> 
                            <img :src="tabela" style="width: 75%;" >
                        </div>
                    </div>
            </div>



        </div>

    </div>    
</template>
