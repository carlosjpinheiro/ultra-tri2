<script setup>
import { RouterLink, useRouter } from "vue-router";
import { themeColor, siteName } from "../data/items";

const router = useRouter();

window.gtranslateSettings = {"default_language":"pt","native_language_names":true,"languages":["pt","fr","de","it","es","en","ru"],"wrapper_selector":".gtranslate_wrapper","switcher_horizontal_position":"right","alt_flags":{"pt":"brazil"}}
</script>


<template>
<nav class="site-nav dark js-site-navbar mb-5 site-navbar-target">
    <div class="container">
      <div class="site-navigation">
        <a class="logo m-0 float-left">
          <RouterLink :to="{ path: '/',  }"  class="nav-link">
            {{ siteName }}
          </RouterLink>
          <!-- <span class="text-primary">.</span> -->
        </a
        >
        <ul class="js-clone-nav d-none d-lg-inline-block site-menu float-left">

          <!-- <li class="active">
            <a class="nav-link"><RouterLink :to="{ path: '/',  }"  class="nav-link">Home</RouterLink></a>
          </li> -->


          <li><a class="nav-link"><RouterLink :to="{ path: '/sobre',  }"  class="nav-link">Sobre</RouterLink></a></li>

          <li><a class="nav-link"><RouterLink :to="{ path: '/contato',  }"  class="nav-link">Contato</RouterLink></a></li>
          <li><a class="nav-link"><RouterLink :to="{ path: '/regulamentos',  }"  class="nav-link">Regulamentos</RouterLink></a></li>
        
        
        </ul>
        <ul
          class="js-clone-nav d-none mt-1 d-lg-inline-block site-menu float-right"
        >
          <!-- <li class="cta-button-outline" style="margin-right: 5px;"><a href="#">Sign in</a></li> -->
          <li class="cta-primary">
            <a :style="[{ backgroundColor: themeColor }]"><RouterLink :to="{ path: '/inscricao',  }"  class="nav-link">Inscreva-se</RouterLink></a>
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

  <!-- <nav class="site-nav dark js-site-navbar mb-5 site-navbar-target">
    <div class="container">

    <div class="gtranslate_wrapper"/>

      <div class="site-navigation">
          <RouterLink :to="{ name: 'home',  }"  class="logo m-0 float-left">
            {{ siteName }}
          
          </RouterLink>

          
        
        <ul class="js-clone-nav d-none d-lg-inline-block site-menu float-left">

          <li>
            <RouterLink :to="{ path: '/sobre',  }"  class="nav-link">Sobre</RouterLink>
          </li>

          <li>
            <a  
              class="nav-link"
              @click="router.push({
                name: 'contato'
              })"  
            >Contato</a>
          </li>

          <li>
            <RouterLink :to="{ name: 'regulamentos',  }"  class="nav-link">Regulamentos</RouterLink>
          </li>

        </ul>
        <ul
          class="js-clone-nav d-none mt-1 d-lg-inline-block site-menu float-right"
        >
          <li class="cta-primary">
              <RouterLink 
              id="inscricao-link"
                :to="{ name: 'inscricao',  }" 
                :style="[{ backgroundColor: themeColor }]"
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
  </nav> -->
</template>

<style>
#inscricao-link:hover {
  color: #fff;
}
</style>
