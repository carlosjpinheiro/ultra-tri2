<script setup>
import { contactInfo } from "../data/items";

const anoAtual = new Date().getFullYear()

const copyrightText = `Copyright ${anoAtual}. Todos direitos reservados. 1.0`;

const socialItems = [
  {
    link: "https://www.instagram.com/brasilultratri/",
    icon: "icon-instagram",
  },
  {
    link: "https://www.facebook.com/brasilultratri/",
    icon: "icon-facebook",
  },
];
</script>

<template>
  <div class="site-footer">
    <!-- <div class="footer-dots"></div> -->
    <div class="container">
      <div class="row mt-n4">
        <div class="col-lg-6">

            <div class="">
              <h4>Brasil Ultra Eventos</h4>
              <!-- <address>{{ contactInfo.address }}</address> -->
              <ul class="list-unstyled links mb-4 w-100">
                <li>
                    <a >
                      <RouterLink :to="{ path: '/cancelamento',}" style="color: black;">
                        Política de reembolso e cancelamento                        
                      </RouterLink>
                  </a>
                </li>
              </ul>
            </div>
          
          <div >
            <ul class="list-unstyled social">
              <li style="margin-right: 4px">
                <a :href="socialItems[0].link" target="_blank"
                  ><span :class="socialItems[0].icon"></span
                ></a>
              </li>
              <li style="margin-right: 4px">
                <a :href="socialItems[1].link" target="_blank"
                  ><span :class="socialItems[1].icon"></span
                ></a>
              </li>
            </ul>
          </div>
        </div>

        <div class="col-lg-3"/>

        <div class="col-lg-3">
          <div class="">
            <h4>Contato</h4>
            <ul class="list-unstyled links mb-4">
              <li>
                <a :href="'mailto:' + contactInfo.email" style="color: black;"
                ><span>{{ contactInfo.email }}</span></a>
              </li>
              <li>
                <a href="https://wa.me/5547992357774" target="_blank" style="color: black;">
                  <span class="icon-whatsapp" style="color: green;"/>                  
                  (47) 99235-7774

                </a>
              </li>
            </ul>
          </div>
        </div>

      </div>

      <div class="row mb-n8">
        <div class="col-12 text-center">
          <p>
            {{ copyrightText }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.site-footer {
  background-color: #fcb603;
}

</style>