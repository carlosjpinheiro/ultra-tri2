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
          <RouterLink :to="{ path: '/',  }"  class="nav-link">
            <img class="mt-n2 ml-n4" :src="ultraTriImg" style="max-width: 100px; ;" >
            <!-- {{ siteName }} -->

          </RouterLink>
        </a
        >
        <ul class="js-clone-nav d-none d-lg-inline-block site-menu float-left">
          <li><a class="nav-link"><RouterLink :to="{ path: '/cronograma',  }" class="nav-link">Cronograma</RouterLink></a></li>

          <!-- <li><a class="nav-link"><RouterLink :to="{ path: '/sobre',  }" class="nav-link">Sobre</RouterLink></a></li> -->

          <li><a class="nav-link"><RouterLink :to="{ path: '/modalidades',  }" class="nav-link">Modalidades</RouterLink></a></li>
          <li><a class="nav-link"><RouterLink :to="{ path: '/valores',  }" class="nav-link">Valores</RouterLink></a></li>
        
          <li><a class="nav-link"><RouterLink :to="{ path: '/regulamentos',  }" class="nav-link">Regulamentos</RouterLink></a></li>
          <li><a class="nav-link"><RouterLink :to="{ path: '/alojamento',  }" class="nav-link">Alojamento</RouterLink></a></li>
          <!-- <li><a class="nav-link"><RouterLink :to="{ path: '/contato',  }" class="nav-link">Contato</RouterLink></a></li> -->
          
        
          <li class="dropdown">
            <a class="nav-link dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Mais
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">


              <ul class="js-clone-nav d-none d-lg-inline-block site-menu float-left">
                <li><a class="nav-link"><RouterLink :to="{ path: '/cronograma',  }" class="nav-link">Cronograma</RouterLink></a></li>

                <!-- <li><a class="nav-link"><RouterLink :to="{ path: '/sobre',  }" class="nav-link">Sobre</RouterLink></a></li> -->

                <li><a class="nav-link"><RouterLink :to="{ path: '/modalidades',  }" class="nav-link">Modalidades</RouterLink></a></li>
                <li><a class="nav-link"><RouterLink :to="{ path: '/valores',  }" class="nav-link">Valores</RouterLink></a></li>
              
                <li><a class="nav-link"><RouterLink :to="{ path: '/regulamentos',  }" class="nav-link">Regulamentos</RouterLink></a></li>
                <li><a class="nav-link"><RouterLink :to="{ path: '/alojamento',  }" class="nav-link">Alojamento</RouterLink></a></li>
                <li><a class="nav-link"><RouterLink :to="{ path: '/contato',  }" class="nav-link">Contato</RouterLink></a></li>
                
              

              </ul>


              <!-- <button class="dropdown-item" type="button">Action</button>
              <button class="dropdown-item" type="button">Another action</button>
              <button class="dropdown-item" type="button">Something else here</button> -->
            </div>
          </li>

        </ul>
        <ul
          class="js-clone-nav d-none mt-1 d-lg-inline-block site-menu float-right"
        >
          <li class="cta-primary nav-link ml-2">
            <RouterLink 
              id="inscricao-link"
              style="border-radius: 15;"
              :style="[
                { backgroundColor: themeColor },
                {borderRadius: '15px'}
                ]" 
              :to="{ path: '/inscricao',  }"  
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
#inscricao-link:hover {
  color: #fff;
}

#header .nav-link {
  max-width: 150px;
}

#header .dropdown {
  /* color: black !important; */
}
</style>
