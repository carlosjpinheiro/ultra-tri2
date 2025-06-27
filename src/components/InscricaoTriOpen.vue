<script setup>
import { ref } from "vue";
import { VForm, VTextField, VBtn } from "vuetify/lib/components/index.mjs";
import Loading from './Loading.vue'
import axios from 'axios';
import getDataFormatada from '../utils/utils'
import {requiredRule, emailRule} from '../utils/validators'
import { initializeApp } from "firebase/app";
import { firebaseConfig } from "../data/firebase";
import { getFirestore, collection, addDoc } from 'firebase/firestore/lite';
import { VDateInput } from "vuetify/lib/labs/components.mjs";

const getNewForm = () => {
    return {
        nome: '',
        sobrenome: '',
        email: '',
        telefone: '',
        nacionalidade: '',
        idade: '',
        dataNascimento: '',
        restricaoAlimentar: '',
        tamanhoCamiseta: '',
        modalidade: '',
        concordaRegulamento: '',
        dataInscricao: '',
        _subject: 'Nova inscrição Tri Open'
    }
}
const app = initializeApp(firebaseConfig);
const db = getFirestore(app);
const valid = ref(false);
const carregando = ref(false)
const formData = ref(getNewForm())
const formInstance = ref(null)
const dataNascimento = ref(null)

const submitForm = async() => {
    axios.defaults.headers.post['Content-Type'] = 'application/json';   

    const validation = await formInstance.value.validate()

    if (validation.valid) {    
        
        // formData.value.dataInscricao = getDataFormatada(new Date());
        formData.value.dataInscricao = new Date()        

        try {
            carregando.value = true
            
            await addDoc(collection(db, "triopen2025"), formData.value);

            alert('Pré-inscrição enviada com sucesso! Aguarde o e-mail da organização do evento para efetivar a inscrição')
            
            formInstance.value.reset()
            // dataNascimento.value = null
        } catch (error) {
            alert('Erro ao enviar o formulário!')
            console.error('Erro ao enviar o formulário:', error);
        } finally {
            carregando.value = false
        }     
    }
}

</script>

<template>
    <div class="untree_co-section" >
        <Loading
            :carregando="carregando"
        />

        <div class="container" style="margin-top: 80px;">
            <div class="row mb-4 mt-8" data-aos="fade-up" data-aos-delay="0">
                <div class="col-12 text-center">
                    <h2 class="heading">Pré-inscrição Brasil Tri Open - Outubro 2025</h2>
                </div>
            </div>

            <br>

            <div>
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8 form">

                        <VForm validate-on="submit lazy" v-model="valid" ref="formInstance" @submit.prevent>

                            <VRow>
                                <VCol>
                                    <VTextField
                                        v-model="formData.nome"
                                        label="*Nome"
                                        variant="outlined"
                                        :rules="[requiredRule]"
                                        validate-on="input"
                                    />                                    
                                </VCol>
                                <VCol>
                                    <VTextField
                                        v-model="formData.sobrenome"
                                        label="*Sobrenome"
                                        variant="outlined"
                                        :rules="[requiredRule]"
                                        validate-on="input"
                                    />                                    
                                </VCol>

                            </VRow>

                            <VRow>
                                <VCol>
                                    <VTextField
                                        v-model="formData.email"
                                        label="*Email"
                                        variant="outlined"
                                        :rules="[requiredRule, emailRule]"
                                        validate-on="input"
                                    />
                                </VCol>
                            </VRow>

                            <VRow>
                                <VCol>
                                    <VTextField
                                        v-model="formData.telefone"
                                        label="Telefone"
                                        variant="outlined"                           
                                    />
                                </VCol>
                            </VRow>

                            <VRow>
                                <VCol>
                                    <VTextField
                                        v-model="formData.nacionalidade"
                                        label="*País/Nacionalidade"
                                        variant="outlined"
                                        :rules="[requiredRule]"
                                        validate-on="input"
                                    />
                                </VCol>
                            </VRow>

                            <VRow>
                                <VCol>
                                    <VTextField
                                        v-model="formData.idade"
                                        label="*Idade"
                                        type="number"
                                        variant="outlined"
                                        :rules="[requiredRule]"
                                        validate-on="input"
                                    />
                                </VCol>
                            </VRow>

                            <VRow>
                                <VCol>
                                    <VTextField
                                        v-model="formData.dataNascimento"
                                        label="*Data de nascimento (mm/dd/aaaa)"
                                        variant="outlined"
                                        validate-on="input"
                                        :rules="[requiredRule]"
                                    />
                                    </VCol>
                            </VRow>

                            <VRow>
                                <VCol>
                                    <VTextarea
                                        v-model="formData.restricaoAlimentar"
                                        label="*Alguma restrição alimentar?"
                                        rows="2"
                                        variant="outlined"
                                        :rules="[requiredRule]"
                                        validate-on="input"
                                    />
                                </VCol>
                            </VRow>

                            <VRow>
                                <VCol>
                                    <VTextField
                                        v-model="formData.tamanhoCamiseta"
                                        label="*Tamanho de camiseta"
                                        variant="outlined"
                                        :rules="[requiredRule]"
                                        validate-on="input"
                                    />
                                </VCol>
                            </VRow>

                            <VRadioGroup 
                                v-model="formData.modalidade"
                                :rules="[requiredRule]"
                                validate-on="input"
                            >
                                <template v-slot:label>
                                    <div>Qual modalidade de interesse:</div>
                                </template>

                                <VRadio label="Triathlon 70.3 (Meio)" value="triathlon_70-3_meio"></VRadio>
                                <VRadio label="Triathlon tradicional" value="triathlon_tradicional"></VRadio>
                            </VRadioGroup>

                            <VCheckbox
                                v-model="formData.concordaRegulamento"
                                label="Concordo com o regulamento completo disponível no site"
                                :rules="[v => !!v || 'Você deve concordar para continuar!']"
                                validate-on="input"
                            />

                            <p>
                                *Importante: A realização deste evento está condicionada a um número mínimo
                                de inscritos. A confirmação definitiva será feita até o dia 31 de agosto.
                            </p>

                            <div style="width: 150px; margin: 0 auto;" class="">

                                <VBtn
                                    :loading="loading"
                                    class="mt-2 px-6 "
                                    text="Enviar"
                                    block
                                    @click="submitForm"
                                    />
                            </div>
                        </VForm>

                    </div>
                </div>
            </div>
        </div>      
    </div>
</template>

<style>
.form {
    color: black;
}
</style>
