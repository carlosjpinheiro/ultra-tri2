<script setup>
import { nextTick, ref } from 'vue';
import { VTextField, VTextarea, VSelect } from 'vuetify/components';
import fields from '../../site-api/schema/staff.json';

const fresh = () => Object.fromEntries(fields.map(f => [f.key, f.type === 'multiple' ? [] : f.type === 'confirm' ? false : '']));
const data = ref(fresh());
const form = ref(null);
const sending = ref(false);
const message = ref('');
const success = ref(false);
const confirmationOpen = ref(false);
const serverErrors = ref({});
const departments = {
  'Produção e Logística': 'Montagem, organização de estruturas e materiais, apoio operacional e demandas gerais do evento.',
  'Suporte aos Atletas': 'Acompanhamento das modalidades, orientação, hidratação, controle de percurso e contato direto com atletas e equipes.',
  'Cozinha e Alimentação': 'Organização e preparação das refeições, reposição de alimentos e suporte à cozinha durante a operação.',
  'Marketing e Produção de Conteúdo': 'Fotos, vídeos, Stories, Reels, cobertura dos bastidores, redes sociais e apoio às ativações de patrocinadores.',
  'Sistema e Cronometragem': 'Acompanhamento e controle de voltas, lançamento/conferência de informações, operação de computadores e suporte à cronometragem.',
  'Não tenho preferência': 'Posso ajudar onde a organização precisar.',
};
const visible = f => !f.when || (Array.isArray(data.value[f.when.key]) ? data.value[f.when.key].includes(f.when.value) : data.value[f.when.key] === f.when.value);
const rules = f => [v => {
  if (f.optional && !v) return true;
  if (f.type === 'confirm') return v === true || 'Confirme para continuar.';
  if (f.type === 'multiple') {
    if (!Array.isArray(v) || !v.length) return 'Selecione ao menos uma opção.';
    if (f.limit && v.length > f.limit) return `Escolha até ${f.limit} opções.`;
    if (f.all && v.length !== f.options.length) return 'Confirme todos os itens para continuar.';
    return true;
  }
  if (!String(v ?? '').trim()) return 'Este campo é obrigatório.';
  if (f.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) return 'Informe um e-mail válido.';
  if (f.type === 'tel' && !/^\+?[\d\s().-]+$/.test(v)) return 'Informe um telefone válido.';
  if (f.type === 'tel' && (v.replace(/\D/g, '').length < 10 || v.replace(/\D/g, '').length > 15)) return 'Informe o WhatsApp com DDD.';
  if (f.type === 'date' && (v < '1900-01-01' || v > new Date().toISOString().slice(0, 10))) return 'Informe uma data de nascimento válida.';
  return true;
}];
async function scrollToFirstError() {
  await nextTick();
  const invalid = form.value?.$el.querySelector('.v-input--error');
  if (!invalid) return;
  const target = invalid.closest('fieldset')
    || (invalid.previousElementSibling?.matches('label') ? invalid.previousElementSibling : invalid);
  const headerHeight = document.querySelector('.ultra-site-header')?.getBoundingClientRect().height || 0;
  const top = target.getBoundingClientRect().top + window.scrollY - headerHeight - 20;
  invalid.querySelector('input:not(:disabled), textarea:not(:disabled), [tabindex="0"]')?.focus({ preventScroll: true });
  window.scrollTo({ top: Math.max(0, top), behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth' });
}
async function submit() {
  if (sending.value) return;
  serverErrors.value = {};
  message.value = '';
  if (!(await form.value.validate()).valid) {
    await scrollToFirstError();
    return;
  }
  sending.value = true;
  try {
    const payload = Object.fromEntries(fields.filter(visible).map(f => [f.key, data.value[f.key]]));
    const response = await fetch('/site-api/v1/staff-registrations', {
      method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload),
    });
    const result = await response.json();
    if (!response.ok) {
      serverErrors.value = result.errors || {};
      throw new Error(result.message || 'Não foi possível enviar. Tente novamente.');
    }
    success.value = true;
    message.value = 'Inscrição enviada com sucesso! A organização entrará em contato pelos dados informados.';
    confirmationOpen.value = true;
    data.value = fresh();
    form.value.resetValidation();
  } catch (error) {
    success.value = false;
    message.value = error instanceof SyntaxError || error instanceof TypeError ? 'Não foi possível conectar ao serviço de inscrições. Tente novamente mais tarde.' : error.message;
  } finally {
    sending.value = false;
    if (Object.keys(serverErrors.value).length) await scrollToFirstError();
  }
}
</script>

<template>
  <div class="ultra-page-body page-staff">
    <VDialog v-model="confirmationOpen" max-width="480" aria-labelledby="staff-confirmation-title">
      <VCard>
        <VCardTitle id="staff-confirmation-title" class="text-wrap">Inscrição recebida!</VCardTitle>
        <VCardText>Sua inscrição para Staff Brasil Ultra Tri 2027 foi enviada com sucesso. A organização entrará em contato pelos dados informados.</VCardText>
        <VCardActions>
          <VBtn color="primary" @click="confirmationOpen = false">Entendi</VBtn>
        </VCardActions>
      </VCard>
    </VDialog>
    <div class="container">
      <div class="staff-intro">
        <h2>Quer viver o Brasil Ultra Tri de um jeito completamente diferente?</h2>
        <p>Durante dias, atletas de diferentes países estarão em Búzios enfrentando alguns dos maiores desafios do triathlon mundial. E por trás de cada quilômetro existe uma equipe fazendo tudo acontecer. Em 2027, você pode fazer parte dela.</p>
        <p>Como staff, você estará diretamente na operação da prova, acompanhando de perto histórias, recordes, madrugadas, chegadas e toda a energia que só quem vive o Brasil Ultra Tri por dentro conhece.</p>
        <h3>O que você poderá fazer</h3>
        <p>As atividades serão distribuídas de acordo com a necessidade da organização e o perfil de cada integrante: controle e apoio aos atletas nos percursos de natação, ciclismo e corrida, cronometragem, hidratação e alimentação, organização de estruturas e materiais, apoio logístico, atendimento aos atletas e suporte geral à operação.</p>
        <p>Os staffs trabalham em turnos de 8 horas por dia, incluindo períodos diurnos e noturnos, com folgas organizadas pela coordenação durante o período de participação.</p>
        <h3>Período e disponibilidade</h3>
        <p><strong>30 de abril a 16 de maio de 2027.</strong> Você não precisa estar disponível durante todo o evento. Teremos oportunidades para períodos de aproximadamente 7 dias, 10 dias ou 16 dias. Sua disponibilidade será considerada na montagem das equipes e escalas.</p>
        <h3>O que oferecemos</h3>
        <ul><li>Refeição correspondente ao seu turno: café da manhã, almoço, jantar ou sopa da madrugada.</li><li>Hospedagem na casa da equipe durante o período em que estiver escalado.</li><li>Declaração de horas complementares.</li><li>Experiência prática em produção, logística e operação esportiva em um evento internacional de ultra triathlon.</li></ul>
        <p>O deslocamento até o Rio de Janeiro é de responsabilidade de cada participante. A organização arcará com o transfer do Rio de Janeiro até Búzios (ida e volta).</p>
        <h3>Mais do que trabalhar em uma prova</h3>
        <p>Ser staff é viver dias intensos, conhecer atletas e pessoas de diferentes lugares do mundo e trabalhar em equipe nos bastidores de um evento que funciona praticamente 24 horas por dia. Tem trabalho, madrugada, imprevisto e cansaço. Mas também tem muita história, amizade, aprendizado e a sensação de pensar: “Eu fiz parte disso!”</p>
      </div>
      <div class="row"><div class="col-lg-8 form">
        <h2>Quer viver o ULTRA com a gente?</h2>
        <p>Estamos formando a equipe que estará conosco em Búzios entre 30 de abril e 16 de maio de 2027. Preencha as informações com atenção. Você não precisa ter experiência anterior em eventos. Buscamos pessoas responsáveis, comprometidas, proativas e dispostas a trabalhar em equipe.</p>
        <p>Campos marcados com * são obrigatórios.</p>
        <VAlert v-if="message" :type="success ? 'success' : 'error'" class="mb-6" role="status">{{ message }}</VAlert>
        <VForm ref="form" validate-on="submit lazy" @submit.prevent="submit" :disabled="sending">
          <template v-for="field in fields" :key="field.key">
            <template v-if="visible(field)">
              <h3 v-if="field.section" class="mt-6">{{ field.section }}</h3>
              <fieldset v-if="field.type === 'multiple'" class="staff-options">
                <legend>{{ field.label }} *</legend>
                <p v-if="field.hint" class="text-body-2">{{ field.hint }}</p>
                <p v-if="field.limit" class="text-body-2">Selecione até {{ field.limit }} opções. Para trocar, desmarque uma das selecionadas.</p>
                <VCheckbox v-for="(option, index) in field.options" :key="option" v-model="data[field.key]" :value="option"
                  :disabled="sending || (!!field.limit && data[field.key].length >= field.limit && !data[field.key].includes(option))"
                  :label="field.key === 'departamentos' ? `${option} — ${departments[option]}` : option"
                  :validation-value="data[field.key]"
                  :rules="field.all ? [() => data[field.key].includes(option) || 'Confirme este item para continuar.'] : index === 0 ? rules(field) : []"
                  :error-messages="index === 0 ? serverErrors[field.key] : []" />
              </fieldset>
              <VCheckbox v-else-if="field.type === 'confirm'" v-model="data[field.key]" :label="`${field.label} *`" :rules="rules(field)" :error-messages="serverErrors[field.key]" />
              <template v-else>
              <label :for="`staff-${field.key}`" class="staff-question">{{ field.label }}{{ field.optional ? ' (opcional)' : ' *' }}</label>
              <component :is="field.type === 'textarea' ? VTextarea : field.type === 'select' ? VSelect : VTextField"
                v-model="data[field.key]" :id="`staff-${field.key}`" :aria-label="field.label"
                variant="outlined" :items="field.options" :type="['date','email','tel'].includes(field.type) ? field.type : 'text'"
                :maxlength="field.max" :rules="rules(field)" :hint="field.hint" :persistent-hint="!!field.hint"
                :error-messages="serverErrors[field.key]" :rows="field.type === 'textarea' ? 3 : undefined" class="mb-4" />
              </template>
            </template>
          </template>
          <VBtn type="submit" :loading="sending" :disabled="sending" block>Enviar inscrição</VBtn>
        </VForm>
      </div></div>
    </div>
  </div>
</template>

<style scoped>
.staff-intro { max-width: 900px; margin: 0 auto 48px; }
.staff-options { border: 0; padding: 0; margin: 12px 0 28px; min-width: 0; }
.staff-options legend { font-weight: 700; font-size: 16px; }
.staff-question { display: block; font-weight: 600; margin-bottom: 10px; }
</style>
