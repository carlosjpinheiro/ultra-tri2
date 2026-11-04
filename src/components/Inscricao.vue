<script setup>
import { computed, ref, watch } from "vue";
import { VForm, VTextField, VBtn } from "vuetify/lib/components/index.mjs";
import Loading from './Loading.vue'
import axios from 'axios';
import {requiredRule, emailRule, dataNascimentoRule} from '../utils/validators'
import { initializeApp } from "firebase/app";
import { firebaseConfig } from "../data/firebase";
import { getFirestore, collection, addDoc } from 'firebase/firestore/lite';
import { modalidadesValores } from "../data/modalidades";

const getNewForm = () => {
    return {
        nome: '',
        sobrenome: '',
        email: '',
        telefone: '',
        nacionalidade: '',
        cpf: '',
        estrangeiro: false,
        idade: '',
        dataNascimento: '',
        provasAnteriores: '',
        restricaoAlimentar: '',
        tamanhoCamiseta: '',
        modalidade: '',
        concordaRegulamento: '',
        dataInscricao: '',
        cupomDesconto: '',
        _subject: 'Nova inscrição Brasil Ultra Tri 2027'
    }
}
const app = initializeApp(firebaseConfig);
const db = getFirestore(app);
const valid = ref(false);
const carregando = ref(false)
const formData = ref(getNewForm())
const formInstance = ref(null)
const cpfField = ref(null)
const cpfRules = computed(() => formData.value.estrangeiro
    ? []
    : [value => !!String(value ?? '').trim() || 'Este campo é obrigatório'])
const dataNascimento = ref(null)

watch(() => formData.value.estrangeiro, (estrangeiro) => {
    if (estrangeiro) {
        cpfField.value?.resetValidation()
    }
}, { flush: 'post' })

const mascaraCpf = (event) => {
    const digitos = event.target.value.replace(/\D/g, '').slice(0, 11);
    const valor = digitos
        .replace(/^(\d{3})(\d)/, '$1.$2')
        .replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3')
        .replace(/(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');

    event.target.value = valor;
    formData.value.cpf = valor;
};

const mascaraDataNascimento = (event) => {
    let valor = event.target.value.replace(/\D/g, '');

    if (valor.length > 8) {
        valor = valor.slice(0, 8);
    }

    if (valor.length > 4) {
        valor = valor.replace(/(\d{2})(\d{2})(\d{1,4})/, '$1/$2/$3');
    } else if (valor.length > 2) {
        valor = valor.replace(/(\d{2})(\d{1,2})/, '$1/$2');
    }

    formData.value.dataNascimento = valor;
};

const submitForm = async() => {
    axios.defaults.headers.post['Content-Type'] = 'application/json';

    const validation = await formInstance.value.validate()

    if (validation.valid) {

        // formData.value.dataInscricao = getDataFormatada(new Date());
        formData.value.dataInscricao = new Date()

        // formData.value.dataNascimento = getDataFormatada(dataNascimento.value);

        try {
            carregando.value = true

            await addDoc(collection(db, "ultratri2027"), formData.value);

            alert('Pré-inscrição enviada com sucesso! Aguarde o e-mail da organização do evento para efetivar a inscrição')

            formInstance.value.reset()
            formData.value = getNewForm()
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
    <div class="ultra-page-body page-inscricao" >
        <Loading
            :carregando="carregando"
        />

        <div class="container" >


            <br>

            <div>
                <div class="row">

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
                                        v-model="formData.cpf"
                                        ref="cpfField"
                                        :label="formData.estrangeiro ? 'CPF (opcional)' : '*CPF'"
                                        :required="!formData.estrangeiro"
                                        variant="outlined"
                                        :rules="cpfRules"
                                        validate-on="input"
                                        inputmode="numeric"
                                        maxlength="14"
                                        @input="mascaraCpf"
                                    />
                                    <VCheckbox
                                        v-model="formData.estrangeiro"
                                        label="Estrangeiro"
                                        hide-details
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
                                        label="*Data de nascimento (dd/mm/aaaa)"
                                        variant="outlined"
                                        validate-on="input"
                                        :rules="[requiredRule, dataNascimentoRule]"
                                        maxlength="10"
                                        @input="mascaraDataNascimento"
                                    />
                                    </VCol>
                            </VRow>

                            <VRow>
                                <VCol>
                                    <VTextarea
                                        v-model="formData.provasAnteriores"
                                        label="*Cite as 3 provas mais importantes de triathlon que você já fez:"
                                        rows="3"
                                        variant="outlined"
                                        :rules="[requiredRule]"
                                        validate-on="input"
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

                            <VRow>
                                <VCol>
                                    <VTextField
                                        v-model="formData.cupomDesconto"
                                        label="Cupom de desconto:"
                                        variant="outlined"
                                    />
                                </VCol>
                            </VRow>
                            <VSelect
                                v-model="formData.modalidade"
                                :items="modalidadesValores"
                                item-title="nome"
                                item-value="nome"
                                label="*Modalidade de interesse"
                                variant="outlined"
                                :rules="[requiredRule]"
                                validate-on="input"
                            />

                            <VCheckbox
                                v-model="formData.concordaRegulamento"
                                :rules="[v => !!v || 'Você deve concordar para continuar!']"
                                validate-on="input"
                            >
                                <template #label>
                                    <span>
                                        Concordo com os
                                        <RouterLink
                                            :to="{ name: 'regulamentos' }"
                                            target="_blank"
                                            @click.stop
                                        >
                                            Regulamentos
                                        </RouterLink>
                                    </span>
                                </template>
                            </VCheckbox>

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
