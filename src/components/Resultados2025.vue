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


    <div class="ultra-page-body page-resultados2025" >
        <div class="container" id="resultados2025" >



            <div v-for="(tabela, index) in tabelas" :key="tabela">

                    <div class="row mt-2 text-center">
                        <div class="col-12">
                            <img :src="tabela" :alt="`Resultados 2025 — tabela ${index + 1}`" class="ultra-result-table" loading="lazy" />
                        </div>
                    </div>
            </div>



        </div>

    </div>
</template>
