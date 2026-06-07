<script setup>
import { cronograma, entregaKit, premiacao } from "../data/cronograma";

</script>

<template>
    <div class="untree_co-section">

        <div
            class="container"
            id="cronograma"
            style="margin-top: 80px;"
        >
            <div class="row">

                <!-- Cronograma -->
                <div class="col-md-6 mb-4 mb-sm-0">

                    <h3 class="mb-4">
                        Cronograma 2027
                    </h3>

                    <p class="mb-4">
                        *Em caso de alterações no cronograma, o atleta será avisado.
                    </p>

                    <ul class="list-group">

                        <li
                            v-for="item in cronograma"
                            :key="item.data"
                            class="list-group-item"
                        >
                            <strong>{{ item.data }}</strong>

                            <div
                                v-for="evento in item.atividades"
                                :key="`${evento.horario}-${evento.descricao}`"
                                class="mt-2"
                            >
                                <template v-if="evento.horario">
                                    Início: {{ evento.horario }}
                                    <br>
                                </template>

                                - {{ evento.descricao }}
                            </div>

                            <small
                                v-if="item.observacao"
                                class="d-block mt-2"
                            >
                                *{{ item.observacao }}
                            </small>

                        </li>

                    </ul>

                </div>

                <!-- Informações -->
                <div class="col-md-6">

                    <h3 class="mb-4">
                        Informações
                    </h3>

                    <h5 class="negrito">
                        Entrega de Kit
                    </h5>

                    <div
                        v-for="item in entregaKit"
                        :key="item.titulo"
                        class="mb-4"
                    >
                        <strong>{{ item.titulo }}</strong>

                        <div
                            v-for="evento in item.eventos"
                            :key="`${evento.horario}-${evento.descricao}`"
                            class="mt-2"
                        >
                            <template v-if="evento.horario">
                                Início: {{ evento.horario }}
                                <br>
                            </template>

                            {{ evento.descricao }}
                        </div>

                        <small
                            v-if="item.observacao"
                            class="d-block mt-2"
                        >
                            {{ item.observacao }}
                        </small>
                    </div>

                    <br>

                    <h5 class="negrito">
                        Premiação
                    </h5>

                    <div
                        v-for="item in premiacao"
                        :key="item.titulo"
                        class="mb-4"
                    >
                        <strong>{{ item.titulo }}</strong>

                        <div
                            v-for="evento in item.eventos"
                            :key="`${evento.horario}-${evento.descricao}`"
                            class="mt-2"
                        >
                            <template v-if="evento.horario">
                                Horário: {{ evento.horario }}
                                <br>
                            </template>

                            {{ evento.descricao }}
                        </div>
                    </div>

                    <p
                        v-for="observacao in observacoesPremiacao"
                        :key="observacao"
                    >
                        {{ observacao }}
                    </p>

                    <p>
                        Atletas do Deca Contínuo e Deca um Por Dia serão premiados após sua
    linha de chegada.

                    </p>
                    <p>
                        Atletas que não poderão comparecer na cerimônia de premiação, poderão
                        ser premiados após sua linha de chegada - informar a organização no dia.

                    </p>

                </div>

            </div>
        </div>

    </div>
</template>

<style>
#cronograma .list-group-item {
    background-color: #fcd70362;
}
</style>
