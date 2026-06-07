<script setup>
import { formatarValor } from "../utils/utils";
import { lotes } from "../data/lotes";
import { modalidadesValores } from "../data/modalidades";

const formatarPeriodo = (lote) => {
  const formatar = (data) =>
    new Date(`${data}T00:00:00`).toLocaleDateString("pt-BR");

  if (!lote.dataInicio) {
    return `Disponível até ${formatar(lote.dataFim)}`;
  }

  return `Início: ${formatar(lote.dataInicio)} até ${formatar(lote.dataFim)}`;
};

const loteEncerrado = (lote) => {
    const hoje = new Date();
    hoje.setHours(0, 0, 0, 0);

    const dataFim = new Date(`${lote.dataFim}T23:59:59`);

    return hoje > dataFim;
};
</script>

<template>
  <div class="untree_co-section" id="valores">
    <div class="container">

      <div class="row mb-4" data-aos="fade-up">
        <div class="col-12 text-center">
          <h2 class="heading text-uppercase negrito">
            Valores de inscrição
          </h2>
        </div>
      </div>

      <div class="row g-4">

        <div v-for="lote in lotes" :key="lote.chave" :class="[
          lote.destaque
            ? 'col-12 mb-5'
            : 'col-lg-4 col-md-6 col-12 mb-2'
        ]">
          <!-- :class="{ destaque: lote.destaque }" -->
          <div class="card h-100 fundo-claro borda-preta" 
          :class="{
            destaque: lote.destaque,
            encerrado: loteEncerrado(lote)
          }"
          >
            <div class="card-body">
              <h3 v-if="lote.destaque" 
                class="text-center text-warning font-weight-bold mb-3" 
                :class="{ 'titulo-encerrado': loteEncerrado(lote) }">
                {{ lote.titulo }}
              </h3>

              <h4 v-else class="text-center"
                :class="{ 'titulo-encerrado': loteEncerrado(lote) }"
              >
                {{ lote.titulo }}
              </h4>

              <p class="text-center">
                {{ formatarPeriodo(lote) }}
              </p>

              <!-- Card promocional -->
              <template v-if="lote.destaque">

                <div class="row">

                  <div class="col-md-6">

                    <ul class="mb-0 lista-modalidades">
                      <li v-for="modalidade in modalidadesValores.filter(m => m.moeda === 'USD')" :key="modalidade.nome">
                        <strong>{{ modalidade.nome }}</strong>
                        |
                        {{ formatarValor(modalidade.valores[lote.chave], modalidade.moeda) }}
                      </li>
                    </ul>

                    <small class="observacao-moeda">
                      Valores em dólar americano, conforme padrão do circuito mundial.
                    </small>

                  </div>

                  <div class="col-md-6">

                    <ul class="mb-0 lista-modalidades">
                      <li v-for="modalidade in modalidadesValores.filter(m => m.moeda === 'BRL')" :key="modalidade.nome">
                        <strong>{{ modalidade.nome }}</strong>
                        |
                        {{ formatarValor(modalidade.valores[lote.chave], modalidade.moeda) }}
                      </li>
                    </ul>

                    <small class="observacao-moeda">
                      Valores em real brasileiro.
                    </small>

                  </div>

                </div>

              </template>

              <!-- Demais cards -->
              <template v-else>

                <ul class="mb-0 lista-modalidades">
                  <li v-for="modalidade in modalidadesValores.filter(m => m.moeda === 'USD')" :key="modalidade.nome">
                    <strong>{{ modalidade.nome }}</strong>
                    |
                    {{ formatarValor(modalidade.valores[lote.chave], modalidade.moeda) }}
                  </li>
                </ul>

                <small class="observacao-moeda">
                  Valores em dólar americano, conforme padrão do circuito mundial.
                </small>

                <hr class="separador-moeda">

                <ul class="mb-0 lista-modalidades">
                  <li v-for="modalidade in modalidadesValores.filter(m => m.moeda === 'BRL')" :key="modalidade.nome">
                    <strong>{{ modalidade.nome }}</strong>
                    |
                    {{ formatarValor(modalidade.valores[lote.chave], modalidade.moeda) }}
                  </li>
                </ul>

                <small class="observacao-moeda">
                  Valores em real brasileiro.
                </small>

              </template>

            </div>
          </div>
        </div>

      </div>

      <div class="mt-5">
        <div class="mb-4">
          <h4>
            Formas de pagamento:
          </h4>
        </div>

        <ul class="ml-8 float-left links w-100">
          <li>À vista via Pix</li>
          <li>Parcelado no cartão de crédito (consultar taxa da operadora)</li>
        </ul>
      </div>

      <div class="mt-5">
        <div class="mb-4">
          <h4>
            Está incluso na inscrição:
          </h4>
        </div>

        <ul class="ml-8 float-left links w-100">
          <li>Kit do atleta</li>
          <li>
            Passe livre no Clube Aretê para atleta e staff durante os dias de prova
          </li>
          <li>
            Alimentação (4 refeições quentes por dia) e hidratação para o atleta
            durante seus dias de prova
          </li>
        </ul>
      </div>

      <p class="font-weight-bold mt-4">
        Será realizado teste antidoping durante a competição, conforme regulamento da IUTA.
      </p>

    </div>
  </div>
</template>

<style>
.destaque {
  background-color: #1A9538;
  color: rgb(255, 249, 221);
}

.lista-modalidades {
  padding-left: 1.5rem;
  margin-bottom: 0;
}

.lista-modalidades li {
  margin-bottom: 0.25rem;
}

.observacao-moeda {
  display: block;
  margin-top: 0.75rem;
  padding-left: 1.5rem;
  font-style: italic;
  opacity: 0.9;
}

.separador-moeda {
  margin: 1rem 0;
  opacity: 0.3;
}

.titulo-encerrado {
    text-decoration: line-through;
    opacity: 0.7;
}

.encerrado {
    opacity: 0.75;
}
</style>