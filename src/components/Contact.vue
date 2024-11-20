<script setup>
import { themeColor, contactInfo } from "../data/items";

const heading = "Fale conosco";
const subHeading = "Tire suas dúvidas, faça um elogio ou reclamação.";
const contactInfoHeading = "Informações para contato";
const buttonSendMessage = "Enviar mensagem";
const labels = {
  firstName: "Nome",
  lastName: "Sobrenome",
  email: "Email",
  message: "Mensagem",
};
</script>

<template>
  <div class="untree_co-section" id="contato">
    <div class="container">

      <div class="row mb-4" data-aos="fade-up" data-aos-delay="0">
        <div class="col-12 text-center">
          <h2 class="heading">Fale conosco</h2>
          <p>Tire suas dúvidas, faça um elogio ou reclamação.</p>
        </div>
      </div>
      
      <div class="row">
        
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
          <form class="contact-form" data-aos="fade-up" data-aos-delay="100" :action="`mailto:${contactInfo.email}`" method="GET">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label class="" for="fname">{{ labels.firstName }}</label>
                  <input type="text" class="form-control" id="fname" />
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label class="" for="lname">{{ labels.lastName }}</label>
                  <input type="text" class="form-control" id="lname" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="" for="email">{{ labels.email }}</label>
              <input type="email" class="form-control" id="email" />
            </div>
            <div class="form-group">
              <label class="" for="message">{{ labels.message }}</label>
              <textarea
                name=""
                class="form-control"
                id="message"
                cols="30"
                rows="5"
              ></textarea>
            </div>
            <button
              type="submit"
              class="btn btn-primary"
              :style="[
                { backgroundColor: themeColor },
                { borderColor: themeColor },
                { color: '#FFF' }
              ]"
            >
              {{ buttonSendMessage }}
            </button>
          </form>
        </div>
      
      </div>
    </div>
  </div>
</template>
