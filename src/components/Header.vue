<script setup>
import { RouterLink, useRouter } from "vue-router";
import { themeColor, siteName } from "../data/items";
import ultraTriImg from "../assets/images/LOGOS_ULTRA_TRI_sem_bixo_fino.png";

</script>

<template>
  <nav class="site-nav dark js-site-navbar mb-5 site-navbar-target">
    
    <div class="container" id="header">
      <div class="site-navigation">
        <a class="logo m-0 float-left">
          <RouterLink :to="{ name: 'home',  }"  class="nav-link">
            <img class="mt-n2 ml-n4" :src="ultraTriImg" style="max-width: 100px; ;" >
            
          </RouterLink>
        </a
        >
        <ul class="js-clone-nav d-none d-lg-inline-block site-menu float-left">
          <li><a class="nav-link"><RouterLink :to="{ name: 'cronograma',  }" class="nav-link">Cronograma</RouterLink></a></li>
          <li><a class="nav-link"><RouterLink :to="{ name: 'modalidades',  }" class="nav-link">Modalidades</RouterLink></a></li>
          <li><a class="nav-link"><RouterLink :to="{ name: 'percurso',  }" class="nav-link">Percurso</RouterLink></a></li>
          <li><a class="nav-link" href="https://www.ultratribrasil.com/resultados/g-live.html?f=eventos/2025/ultratri2025/brasil-ultra-tri-2025.clax" target="_blank" style="color: black;"><span  class="nav-link ml-1">Resultados</span></a></li>
          <li><a class="nav-link"><RouterLink :to="{ name: 'startlist',  }" class="nav-link">Start List</RouterLink></a></li>
                
          <li class="dropdown">
            <a class="nav-link dropdown-toggle hide-expanded" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Mais
            </a>
            <div 
            style="background-color: #F0EFEB;"
            :style="[
              {
                borderRadius: '10px'
              }
            ]" 
              class="dropdown-menu" 
              aria-labelledby="dropdownMenu2">
              
              <ul class="js-clone-nav d-none d-lg-inline-block site-menu float-left">
                <li><a class="nav-link"><RouterLink :to="{ name: 'regulamentos',  }" class="nav-link">Regulamentos</RouterLink></a></li>
                <li><a class="nav-link"><RouterLink :to="{ name: 'valores',  }" class="nav-link">Valores</RouterLink></a></li>             
                <li><a class="nav-link"><RouterLink :to="{ name: 'alojamento',  }" class="nav-link">Alojamento</RouterLink></a></li>
                <li><a class="nav-link"><RouterLink :to="{ name: 'comochegar',  }" class="nav-link">Como chegar</RouterLink></a></li>
                <li><a class="nav-link"><RouterLink :to="{ name: 'organizacao',  }" class="nav-link">Organização</RouterLink></a></li>
                <li><a class="nav-link"><RouterLink :to="{ name: 'sobre',  }" class="nav-link">Sobre</RouterLink></a></li>
                <li><a class="nav-link"><RouterLink :to="{ name: 'contato',  }" class="nav-link">Contato</RouterLink></a></li>                
              </ul>
            </div>
          </li>

        </ul>
        <ul
          class="js-clone-nav d-none mt-1 d-lg-inline-block site-menu float-right"
        >
          <li class="cta-primary nav-link ml-2">
            <RouterLink 
              id="inscricao-link"
              :style="[
                { backgroundColor: themeColor },
                {borderRadius: '15px'}
                ]" 
              :to="{ name: 'inscricao',  }"  
              class="nav-link"
            >
              Inscreva-se
            </RouterLink>
          </li>
        </ul>
        <a
          href="#"
          class="burger ml-auto float-right site-menu-toggle js-menu-toggle d-inline-block dark d-lg-none"
          data-toggle="collapse"
          data-target="#main-navbar"
        >
          <span></span>
        </a>
      </div>
    </div>
  </nav>
  
</template>

<style>
nav {
  background-color: #fcb603 !important;
}

#inscricao-link:hover {
  color: #fff;
}

#header .nav-link {
  max-width: 150px;
}

#header .dropdown {
  /* color: black !important; */
}

.dropdown .nav-link:hover{
  opacity: 0.7;
}

.site-mobile-menu .hide-expanded {  
  display: none !important;
/* background-color: red; */
}
</style>
