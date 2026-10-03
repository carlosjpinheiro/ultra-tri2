import deca from "../assets/images/mod-deca.png";
import quintuplo from "../assets/images/mod-quintuplo.png";
import triplo from "../assets/images/mod-triplo.png";
import duplo from "../assets/images/mod-duplo.png";
import single from "../assets/images/mod-single.png";
import corridas from "../assets/images/mod-corridas.png";
import ciclismo from "../assets/images/mod-ciclismo.png";
import meiotriathlon from "../assets/images/mod-meio-triathlon.png";

// Fonte única para os cards, os valores e a pré-inscrição.
// Preços ainda não definidos ficam como null.
const modalidades = [
  {
    "id": "deca-continuo",
    "img": deca,
    "titulo": "Deca contínuo",
    "provas": "38 km natação | 1.800 km ciclismo | 422 km corrida",
    "cortes": [
      "Natação: 26 horas",
      "Natação + T1 + Bike: 192 horas",
      "Total: 336 horas"
    ],
    "ativo": true,
    "nome": "DECA CONTINUOUS",
    "moeda": "USD",
    "valores": {
      "preAbertura": 2150,
      "primeiroLote": 2300,
      "segundoLote": 2550,
      "ultimoLote": 2800
    },
    "ordemValores": 0
  },
  {
    "id": "deca-por-dia",
    "img": deca,
    "titulo": "Deca um por dia",
    "provas": "3,8 km natação | 180 km ciclismo | 42 km corrida",
    "cortes": [
      "Total: 23:30h",
      "*por dia"
    ],
    "ativo": true,
    "nome": "DECA UM POR DIA",
    "moeda": "USD",
    "valores": {
      "preAbertura": 2150,
      "primeiroLote": 2300,
      "segundoLote": 2550,
      "ultimoLote": 2800
    },
    "ordemValores": 1
  },
  {
    "id": "quintuplo-continuo",
    "img": quintuplo,
    "titulo": "Quintuplo contínuo",
    "provas": "19 km natação | 900 km ciclismo | 211 km corrida",
    "cortes": [
      "Natação: 12 horas",
      "Natação + T1 + Bike: 86 horas",
      "Total: 144 horas"
    ],
    "ativo": true,
    "nome": "QUINTUPLO CONTINUOUS",
    "moeda": "USD",
    "valores": {
      "preAbertura": 1100,
      "primeiroLote": 1300,
      "segundoLote": 1450,
      "ultimoLote": 1600
    },
    "ordemValores": 2
  },
  {
    "id": "quintuplo-por-dia",
    "img": quintuplo,
    "titulo": "Quintuplo um por dia",
    "provas": "3,8 km natação | 180 km ciclismo | 42 km corrida",
    "cortes": [
      "Total: 23:30 horas",
      "*por dia"
    ],
    "ativo": true,
    "nome": "QUINTUPLO UM POR DIA",
    "moeda": "USD",
    "valores": {
      "preAbertura": 1100,
      "primeiroLote": 1300,
      "segundoLote": 1450,
      "ultimoLote": 1600
    },
    "ordemValores": 3
  },
  {
    "id": "triplo-continuo",
    "img": triplo,
    "titulo": "Triplo contínuo",
    "provas": "11,4 km natação | 540 km ciclismo | 126 km corrida",
    "cortes": [
      "Natação: 6 horas",
      "Natação + T1 + Bike: 36 horas",
      "Total: 60 horas"
    ],
    "ativo": true,
    "nome": "TRIPLO CONTINUOUS",
    "moeda": "USD",
    "valores": {
      "preAbertura": 700,
      "primeiroLote": 800,
      "segundoLote": 950,
      "ultimoLote": 1100
    },
    "ordemValores": 4
  },
  {
    "id": "duplo-continuo",
    "img": duplo,
    "titulo": "Duplo contínuo",
    "provas": "7,6 km natação | 360 km ciclismo | 84 km corrida",
    "cortes": [
      "Natação: 4 horas",
      "Natação + T1 + Bike: 24 horas",
      "Total: 36 horas"
    ],
    "ativo": true,
    "nome": "DUPLO CONTINUOUS",
    "moeda": "USD",
    "valores": {
      "preAbertura": 600,
      "primeiroLote": 700,
      "segundoLote": 850,
      "ultimoLote": 1000
    },
    "ordemValores": 5
  },
  {
    "id": "duplo-por-dia",
    "img": duplo,
    "titulo": "Duplo um por dia",
    "provas": "3,8 km natação | 180 km ciclismo | 42 km corrida",
    "cortes": [
      "Total: 23:30 horas",
      "*por dia"
    ],
    "ativo": true,
    "nome": "DUPLO UM POR DIA",
    "moeda": "USD",
    "valores": {
      "preAbertura": 600,
      "primeiroLote": 700,
      "segundoLote": 850,
      "ultimoLote": 1000
    },
    "ordemValores": 6
  },
  {
    "id": "single-triathlon",
    "img": single,
    "titulo": "Single Triathlon",
    "provas": "3,8 km natação | 180 km ciclismo | 42 km corrida",
    "cortes": [
      "Natação: 2,5 horas",
      "Natação + T1 + Bike: 10 horas",
      "Total: 18 horas"
    ],
    "ativo": true,
    "nome": "TRIATHLON TRADICIONAL",
    "moeda": "BRL",
    "valores": {
      "preAbertura": 2000,
      "primeiroLote": 2300,
      "segundoLote": 2500,
      "ultimoLote": 2800
    },
    "ordemValores": 7
  },
  {
    "id": "meio-triathlon",
    "img": meiotriathlon,
    "titulo": "Meio Triathlon",
    "provas": "1,9 km natação | 90 km ciclismo | 21 km corrida",
    "cortes": [
      "Natação: 1,5 horas",
      "Natação + T1 + Bike: 5 horas",
      "Total: 8 horas"
    ],
    "ativo": true,
    "nome": "MEIO TRIATHLON",
    "moeda": "BRL",
    "valores": {
      "preAbertura": 1500,
      "primeiroLote": 1800,
      "segundoLote": 2000,
      "ultimoLote": 2200
    },
    "ordemValores": 8
  },
  {
    "id": "corrida-100km",
    "img": corridas,
    "titulo": "Corrida",
    "provas": "Corrida 100km",
    "cortes": [
      "Tempo limite: 14hrs"
    ],
    "ativo": true,
    "nome": "CORRIDA 100KM",
    "moeda": "BRL",
    "valores": {
      "preAbertura": 400,
      "primeiroLote": 450,
      "segundoLote": 500,
      "ultimoLote": 560
    },
    "ordemValores": 13
  },
  {
    "id": "corrida-24h",
    "img": corridas,
    "titulo": "Corrida",
    "provas": "Corrida 24 Horas",
    "cortes": [
      "Tempo limite: 24hrs"
    ],
    "ativo": true,
    "nome": "CORRIDA 24 HORAS",
    "moeda": "BRL",
    "valores": {
      "preAbertura": 450,
      "primeiroLote": 500,
      "segundoLote": 600,
      "ultimoLote": 660
    },
    "ordemValores": 9
  },
  {
    "id": "corrida-12h",
    "img": corridas,
    "titulo": "Corrida",
    "provas": "Corrida 12 Horas",
    "cortes": [
      "Tempo limite: 12hrs"
    ],
    "ativo": true,
    "nome": "CORRIDA 12 HORAS",
    "moeda": "BRL",
    "valores": {
      "preAbertura": 380,
      "primeiroLote": 430,
      "segundoLote": 500,
      "ultimoLote": 550
    },
    "ordemValores": 10
  },
  {
    "id": "corrida-6h",
    "img": corridas,
    "titulo": "Corrida",
    "provas": "Corrida 06 Horas",
    "cortes": [
      "Tempo limite: 06hrs"
    ],
    "ativo": true,
    "nome": "CORRIDA 06 HORAS",
    "moeda": "BRL",
    "valores": {
      "preAbertura": 330,
      "primeiroLote": 380,
      "segundoLote": 430,
      "ultimoLote": 490
    },
    "ordemValores": 11
  },
  {
    "id": "corrida-3h",
    "img": corridas,
    "titulo": "Corrida",
    "provas": "Corrida 03 Horas",
    "cortes": [
      "Tempo limite: 03hrs"
    ],
    "ativo": true,
    "nome": "CORRIDA 03 HORAS",
    "moeda": "BRL",
    "valores": {
      "preAbertura": 260,
      "primeiroLote": 310,
      "segundoLote": 360,
      "ultimoLote": 410
    },
    "ordemValores": 12
  },
  {
    "id": "pedal-1000km",
    "img": ciclismo,
    "titulo": "Ciclismo",
    "provas": "Pedal 1.000 Kms",
    "cortes": [
      "Tempo limite: 60hrs"
    ],
    "ativo": true,
    "nome": "CICLISMO 1.000KM",
    "moeda": "BRL",
    "valores": {
      "preAbertura": null,
      "primeiroLote": null,
      "segundoLote": 1200,
      "ultimoLote": 1350
    },
    "ordemValores": 14
  },
  {
    "id": "pedal-500km",
    "img": ciclismo,
    "titulo": "Ciclismo",
    "provas": "Pedal 500 Kms",
    "cortes": [
      "Tempo limite: 24hrs"
    ],
    "ativo": true,
    "nome": "CICLISMO 500KM",
    "moeda": "BRL",
    "valores": {
      "preAbertura": null,
      "primeiroLote": null,
      "segundoLote": 850,
      "ultimoLote": 950
    },
    "ordemValores": 15
  },
  {
    "id": "pedal-100km",
    "img": ciclismo,
    "titulo": "Ciclismo",
    "provas": "Pedal 100 Kms",
    "cortes": [
      "Tempo limite: 05hrs"
    ],
    "ativo": true,
    "nome": "CICLISMO 100KM",
    "moeda": "BRL",
    "valores": {
      "preAbertura": null,
      "primeiroLote": null,
      "segundoLote": 400,
      "ultimoLote": 450
    },
    "ordemValores": 16
  }
];

const modalidadesAtivas = modalidades.filter(modalidade => modalidade.ativo);

const modalidadesValores = [...modalidadesAtivas]
  .sort((a, b) => a.ordemValores - b.ordemValores);

export { modalidades, modalidadesAtivas, modalidadesValores };
