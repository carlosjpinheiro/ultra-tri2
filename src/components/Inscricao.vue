<script setup>
import { computed, ref, watch } from "vue";
import { VForm, VTextField, VBtn } from "vuetify/lib/components/index.mjs";
import Loading from './Loading.vue'
import MessageDialog from './MessageDialog.vue';
import {requiredRule, emailRule, dataNascimentoRule} from '../utils/validators'
import { submitAthleteRegistration } from '../utils/athleteRegistration';
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
const valid = ref(false);
const carregando = ref(false)
const dialogOpen = ref(false);
const dialogTitle = ref('');
const dialogMessage = ref('');
const dialogType = ref('info');
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
    if (carregando.value) return;

    const validation = await formInstance.value.validate()

    if (validation.valid) {

        // formData.value.dataInscricao = getDataFormatada(new Date());
        formData.value.dataInscricao = new Date()

        // formData.value.dataNascimento = getDataFormatada(dataNascimento.value);

        try {
            carregando.value = true

            await submitAthleteRegistration(formData.value);

            dialogTitle.value = 'Pré-inscrição recebida!';
            dialogMessage.value = 'Pré-inscrição enviada com sucesso! Aguarde o e-mail da organização do evento para efetivar a inscrição.';
            dialogType.value = 'success';
            dialogOpen.value = true;

            formInstance.value.reset()
            formData.value = getNewForm()
            // dataNascimento.value = null
        } catch (error) {
            dialogTitle.value = 'Não foi possível enviar';
            dialogMessage.value = error instanceof TypeError
                ? 'Não foi possível conectar ao serviço de inscrições. Tente novamente mais tarde.'
                : error.message || 'Erro ao enviar o formulário. Tente novamente.';
            dialogType.value = 'error';
            dialogOpen.value = true;
            console.error('Erro ao enviar o formulário:', error);
        } finally {
            carregando.value = false
        }
    }
}

</script>

<template>
    <div class="ultra-page-body page-inscricao">
        <MessageDialog
            v-model="dialogOpen"
            :title="dialogTitle"
            :message="dialogMessage"
            :type="dialogType"
        />
        <Loading :carregando="carregando" />
        <div class="container">
            <div class="row">
                <div class="col-lg-8 form">
                    <p>Campos marcados com * são obrigatórios.</p>
                    <VForm
                        ref="formInstance"
                        v-model="valid"
                        validate-on="submit lazy"
                        :disabled="carregando"
                        @submit.prevent="submitForm"
                    >
                        <label for="athlete-nome" class="athlete-question">Nome *</label>
                        <VTextField
                            id="athlete-nome"
                            v-model="formData.nome"
                            variant="outlined"
                            :rules="[requiredRule]"
                            validate-on="input"
                            class="mb-4"
                        />

                        <label for="athlete-sobrenome" class="athlete-question">Sobrenome *</label>
                        <VTextField
                            id="athlete-sobrenome"
                            v-model="formData.sobrenome"
                            variant="outlined"
                            :rules="[requiredRule]"
                            validate-on="input"
                            class="mb-4"
                        />

                        <label for="athlete-email" class="athlete-question">E-mail *</label>
                        <VTextField
                            id="athlete-email"
                            v-model="formData.email"
                            type="email"
                            variant="outlined"
                            :rules="[requiredRule, emailRule]"
                            validate-on="input"
                            class="mb-4"
                        />

                        <label for="athlete-telefone" class="athlete-question">Telefone (opcional)</label>
                        <VTextField
                            id="athlete-telefone"
                            v-model="formData.telefone"
                            type="tel"
                            variant="outlined"
                            class="mb-4"
                        />

                        <label for="athlete-nacionalidade" class="athlete-question">País / Nacionalidade *</label>
                        <VTextField
                            id="athlete-nacionalidade"
                            v-model="formData.nacionalidade"
                            variant="outlined"
                            :rules="[requiredRule]"
                            validate-on="input"
                            class="mb-4"
                        />

                        <label for="athlete-cpf" class="athlete-question">
                            {{ formData.estrangeiro ? 'CPF (opcional)' : 'CPF *' }}
                        </label>
                        <VTextField
                            id="athlete-cpf"
                            ref="cpfField"
                            v-model="formData.cpf"
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
                            class="mb-4"
                        />

                        <label for="athlete-idade" class="athlete-question">Idade *</label>
                        <VTextField
                            id="athlete-idade"
                            v-model="formData.idade"
                            type="number"
                            variant="outlined"
                            :rules="[requiredRule]"
                            validate-on="input"
                            class="mb-4"
                        />

                        <label for="athlete-dataNascimento" class="athlete-question">Data de nascimento (dd/mm/aaaa) *</label>
                        <VTextField
                            id="athlete-dataNascimento"
                            v-model="formData.dataNascimento"
                            variant="outlined"
                            :rules="[requiredRule, dataNascimentoRule]"
                            validate-on="input"
                            maxlength="10"
                            @input="mascaraDataNascimento"
                            class="mb-4"
                        />

                        <label for="athlete-provasAnteriores" class="athlete-question">Cite as 3 provas mais importantes de triathlon que você já fez *</label>
                        <VTextarea
                            id="athlete-provasAnteriores"
                            v-model="formData.provasAnteriores"
                            rows="3"
                            variant="outlined"
                            :rules="[requiredRule]"
                            validate-on="input"
                            class="mb-4"
                        />

                        <label for="athlete-restricaoAlimentar" class="athlete-question">Alguma restrição alimentar? *</label>
                        <VTextarea
                            id="athlete-restricaoAlimentar"
                            v-model="formData.restricaoAlimentar"
                            rows="2"
                            variant="outlined"
                            :rules="[requiredRule]"
                            validate-on="input"
                            class="mb-4"
                        />

                        <label for="athlete-tamanhoCamiseta" class="athlete-question">Tamanho de camiseta *</label>
                        <VTextField
                            id="athlete-tamanhoCamiseta"
                            v-model="formData.tamanhoCamiseta"
                            variant="outlined"
                            :rules="[requiredRule]"
                            validate-on="input"
                            class="mb-4"
                        />

                        <label for="athlete-cupomDesconto" class="athlete-question">Cupom de desconto (opcional)</label>
                        <VTextField
                            id="athlete-cupomDesconto"
                            v-model="formData.cupomDesconto"
                            variant="outlined"
                            class="mb-4"
                        />

                        <label for="athlete-modalidade" class="athlete-question">Modalidade de interesse *</label>
                        <VSelect
                            id="athlete-modalidade"
                            v-model="formData.modalidade"
                            :items="modalidadesValores"
                            item-title="nome"
                            item-value="nome"
                            variant="outlined"
                            :rules="[requiredRule]"
                            validate-on="input"
                            class="mb-4"
                        />

                        <VCheckbox
                            v-model="formData.concordaRegulamento"
                            :rules="[v => !!v || 'Você deve concordar para continuar!']"
                            validate-on="input"
                            class="mb-4"
                        >
                            <template #label>
                                <span>
                                    Concordo com os
                                    <RouterLink :to="{ name: 'regulamentos' }" target="_blank" @click.stop>
                                        Regulamentos
                                    </RouterLink>
                                </span>
                            </template>
                        </VCheckbox>

                        <VBtn type="submit" :loading="carregando" :disabled="carregando" block>
                            Enviar
                        </VBtn>
                    </VForm>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.athlete-question {
    display: block;
    font-weight: 600;
    margin-bottom: 10px;
}
</style>
