<script setup>
import { contactInfo } from "../data/items";

const anoAtual = new Date().getFullYear()

const copyrightText = `Copyright ${anoAtual}, Todos direitos reservados.`;

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
      <div class="row">
        <div class="col-lg-6">

            <div class="widget">
              <h3>Brasil Ultra Eventos</h3>
              <!-- <address>{{ contactInfo.address }}</address> -->
              <ul class="list-unstyled links mb-4 w-100">
                <li>
                    <a >
                      <RouterLink :to="{ path: '/cancelamento',}">
                        Política de reembolso e cancelamento                        
                      </RouterLink>
                  </a>
                </li>
              </ul>
            </div>
          
          <div >
            <ul class="list-unstyled social">
              <li style="margin-right: 4px">
                <a :href="socialItems[0].link"
                  ><span :class="socialItems[0].icon"></span
                ></a>
              </li>
              <li style="margin-right: 4px">
                <a :href="socialItems[1].link"
                  ><span :class="socialItems[1].icon"></span
                ></a>
              </li>
            </ul>
          </div>
        </div>

        <div class="col-lg-3"/>

        <div class="col-lg-3">
          <div class="widget">
            <h3>Contato</h3>
            <!-- <address>{{ contactInfo.address }}</address> -->
            <ul class="list-unstyled links mb-4">
              <!-- <li>
                <a :href="'tel://' + contactInfo.phone2">{{
                  contactInfo.phone2
                }}</a>
              </li> -->
              <li>
                <a :href="'mailto:' + contactInfo.email"
                  ><span>{{ contactInfo.email }}</span></a
                >
              </li>
            </ul>
          </div>
        </div>

      </div>

      <div class="row ">
        <div class="col-12 text-center">
          <p>
            {{ copyrightText }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
