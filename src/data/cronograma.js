const cronograma = [
    {
        data: '01 de maio - Sábado',
        atividades: [
            {
                horario: '09h00',
                descricao: 'Largada DECA CONTÍNUO'
            }
        ]
    },
    {
        data: '04 de maio - Terça-feira',
        atividades: [
            {
                horario: '07h00',
                descricao: 'Largada DECA UM POR DIA e QUINTUPLO UM POR DIA'
            }
        ]
    },
    {
        data: '05 de maio - Quarta-feira',
        atividades: [
            {
                horario: '09h30',
                descricao: 'Largada QUINTUPLO CONTÍNUO'
            }
        ]
    },
    {
        data: '07 de maio - Quinta-feira',
        atividades: [
            {
                horario: '09h00',
                descricao: 'Largada TRIPLO CONTÍNUO'
            }
        ]
    },
    {
        data: '09 de maio - Sábado',
        atividades: [
            {
                horario: '09h00',
                descricao: 'Largada DUPLO CONTÍNUO'
            }
        ]
    },
    {
        data: '15 de maio - Sábado',
        atividades: [
            {
                horario: '07h00',
                descricao: 'Largada Triathlon Tradicional e Meio Triathlon'
            },
            {
                horario: '10h00',
                descricao: 'Largada Corrida 24 horas'
            },
            {
                horario: '19h00',
                descricao: 'Largada Corrida 100KM'
            },
            {
                horario: '22h00',
                descricao: 'Largada Corrida 12 horas e Corrida 06 horas'
            }
        ]
    },
    {
        data: '16 de maio - Domingo',
        atividades: [
            {
                horario: '07h00',
                descricao: 'Largada Corrida 03 horas'
            }
        ]
    }
]

const entregaKit = [
    {
        titulo: '30 de abril',
        eventos: [
            {
                horario: '15h00',
                descricao: 'Somente para atletas do DECA CONTÍNUO'
            }
        ]
    },
    {
        titulo: '03 de maio',
        eventos: [
            {
                horario: '15h00',
                descricao: 'Para os atletas do Deca Um por Dia, Quíntuplo Um por Dia, Quíntuplo Contínuo, Triplo Contínuo e Duplo Contínuo'
            }
        ]
    },
    {
        titulo: '14 de maio',
        eventos: [
            {
                horario: '15h00',
                descricao: 'Para os atletas do Triathlon Tradicional, Meio Triathlon e Corridas'
            }
        ],
        observacao: 'Atletas que não conseguirem comparecer no dia da entrega do seu kit poderão retirá-lo qualquer outro dia antes da sua largada com nossa equipe.'
    }
]

const premiacao = [
    {
        titulo: '11 de maio',
        eventos: [
            {
                horario: '11h00',
                descricao: 'Para atletas do Quíntuplo Contínuo, Quíntuplo Um por Dia, Triplo Contínuo e Duplo Contínuo'
            }
        ]
    },
    {
        titulo: '15 de maio',
        eventos: [
            {
                horario: '11h00',
                descricao: 'Para atletas do Triathlon Tradicional, Meio Triathlon e Corridas'
            }
        ]
    }
]

export {cronograma, entregaKit, premiacao}