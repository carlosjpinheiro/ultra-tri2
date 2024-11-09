<script setup>
import { ref } from "vue";
import { VForm, VTextField, VBtn } from "vuetify/lib/components/index.mjs";
import Loading from './Loading.vue'
import axios from 'axios';
import getDataAtual from '../utils/utils'
import { contactInfo } from "../data/items";
import { initializeApp } from "firebase/app";
import { firebaseConfig } from "../data/firebase";
import { getFirestore, collection, getDocs, addDoc, setDoc, doc, deleteDoc } from 'firebase/firestore/lite';

const app = initializeApp(firebaseConfig);
const db = getFirestore(app);
const valid = ref(false);
const carregando = ref(false)

const formulario = ref({
    nome: '',
    sobrenome: '',
    email: '',
    telefone: '',
    nacionalidade: '',
    idade: '',
    dataNascimento: '',
    provasAnteriores: '',
    restricaoAlimentar: '',
    tamanhoCamiseta: '',
    modalidade: '',
    concordaRegulamento: '',
    dataInscricao: '',
    _subject: 'Nova inscrição Brasil Ultra Tri'
})

const submitForm = async() => {
    axios.defaults.headers.post['Content-Type'] = 'application/json';   

    if (valid.value) {    
        try {
            formulario.value.dataInscricao = getDataAtual();
            
            // console.log('form', formulario.value);
            carregando.value = true
            const response = await axios.post(`https://formsubmit.co/ajax/${contactInfo.email}`, formulario.value);
            enviaFirebase()

            alert('Inscrição enviada com sucesso!')
        } catch (error) {
            console.error('Erro ao enviar o formulário:', error);
        } finally {
            carregando.value = false
        }     
    }
};

const enviaFirebase = async() => {
    try {
        const docRef = await addDoc(collection(db, "inscricoes"), formulario.value);
        // console.log("Document written with ID: ", docRef.id);
    } catch (e) {
        console.error("Error adding document: ", e);
    }
}

</script>

<template>
    <div class="untree_co-section" >
        <Loading
         :carregando="carregando"
        />

        <div class="container">


            <div class="row mb-4 mt-8" data-aos="fade-up" data-aos-delay="0">
                <div class="col-12 text-center">
                    <h2 class="heading">Pré-inscrição Brasil Ultra Tri 2025</h2>
                </div>
            </div>
            <br>
            <div>


            <VRow>
                <VCol cols="2"/>
                <VCol cols='8'>


                    <VForm class="form" validate-on="submit lazy" v-model="valid" ref="form" @submit.prevent="submitForm">

                        <VRow>
                            <VCol>
                                <VTextField
                                    v-model="formulario.nome"
                                    label="*Nome"
                                />
                                
                            </VCol>
                            <VCol>
                                <VTextField
                                    v-model="formulario.sobrenome"
                                    
                                    label="*Sobrenome"
                                />
                                
                            </VCol>

                        </VRow>

                        <VRow>
                            <VCol>
                                <VTextField
                                    v-model="formulario.email"
                                    
                                    label="*Email"
                                />
                            </VCol>
                        </VRow>

                        <VRow>
                            <VCol>
                                <VTextField
                                    v-model="formulario.telefone"
                                    
                                    label="Telefone"
                                />
                            </VCol>
                        </VRow>

                        <VRow>
                            <VCol>
                                <VTextField
                                    v-model="formulario.nacionalidade"
                                    
                                    label="*País/Nacionalidade"
                                />
                            </VCol>
                        </VRow>

                        <VRow>
                            <VCol>
                                <VTextField
                                    v-model="formulario.idade"
                                    
                                    label="*Idade"
                                />
                            </VCol>
                        </VRow>

                        <VRow>
                            <VCol>
                                <VTextField
                                    v-model="formulario.dataNascimento"
                                    
                                    label="*Data de nascimento"
                                />
                            </VCol>
                        </VRow>

                        <VRow>
                            <VCol>
                                <VTextarea
                                    v-model="formulario.provasAnteriores"
                                    
                                    label="*Cite 3 provas mais importantes de triathlon que você já fez:"
                                />
                            </VCol>
                        </VRow>

                        <VRow>
                            <VCol>
                                <VTextarea
                                    v-model="formulario.restricaoAlimentar"
                                    
                                    label="*Alguma restrição alimentar?"
                                />
                            </VCol>
                        </VRow>

                        <VRow>
                            <VCol>
                                <VTextField
                                    v-model="formulario.tamanhoCamiseta"
                                    
                                    label="*Tamanho de camiseta"
                                />
                            </VCol>
                        </VRow>

                        <VRadioGroup v-model="formulario.modalidade">
                            <template v-slot:label>
                                <div>Qual modalidade de interesse:</div>
                            </template>

                            <VRadio label="Deca continuous" value="deca"></VRadio>
                            <VRadio label="Quintuplo continuous" value="quintuplo"></VRadio>
                            <VRadio label="Triplo continuous" value="triplo"></VRadio>
                            <VRadio label="Duplo continuous" value="duplo"></VRadio>
                            <VRadio label="Single" value="single"></VRadio>
                            <VRadio label="Corrida: 5 maratonas" value="corridacincomaratonas"></VRadio>
                            <VRadio label="Corrida: 100km" value="corridacemkm"></VRadio>
                            <VRadio label="Corrida: Maratona" value="corridamaratona"></VRadio>
                        </VRadioGroup>

                        <VCheckbox
                            v-model="formulario.concordaRegulamento"
                            :rules="[v => !!v || 'Você deve concordar para continuar!']"
                            label="Concordo com o regulamento completo disponível no site"
                            required
                        />
            
                        <!-- :disabled="!valid" -->
                        <VBtn
                            :loading="loading"
                            class="mt-2 px-6"
                            text="Enviar"
                            type="submit"
                            block
                        />
                    </VForm>
                </VCol>
            </VRow>
        </div>        

        </div>
      
      </div>
</template>

<style>
.form {
    color: black;
}
</style>
