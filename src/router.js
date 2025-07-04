import { createRouter, createWebHistory } from 'vue-router';
import Inscricao from './components/Inscricao.vue'
import Regulamentos from './components/Regulamentos.vue'
import Cancelamento from './components/Cancelamento.vue'
import Alojamento from './components/Alojamento.vue'
import Cronograma from './components/Cronograma.vue'
import ComoChegar from './components/ComoChegar.vue'
import Organizacao from './components/Organizacao.vue'
import Home from './components/Home.vue'
import StartList from './components/StartList.vue'
import Percurso from './components/Percurso.vue'
import TriOpen from './components/TriOpen.vue'
import InscricaoTriOpen from './components/InscricaoTriOpen.vue'

const routes = [
    { name: 'home', path: '/', meta: { name: 'home' }, component: Home, },
    { name: 'sobre', path: '/sobre', meta: { name: 'Sobre' }, redirect: { name: 'home', hash: '#sobre' } },
    { name: 'modalidades', path: '/modalidades', meta: { name: 'Modalidades' }, redirect: { name: 'home', hash: '#modalidades' } },
    { name: 'arete', path: '/arete', meta: { name: 'Arete' }, redirect: { name: 'home', hash: '#arete' } },
    { name: 'contato', path: '/contato', meta: { name: 'Contato' }, redirect: { name: 'home', hash: '#contato' } },
    { name: 'valores', path: '/valores', meta: { name: 'Valores' }, redirect: { name: 'home', hash: '#valores' } },

    { name: 'inscricaotriopen', path: '/inscricaotriopen', component: InscricaoTriOpen },
    { name: 'triopen', path: '/triopen', component: TriOpen },
    { name: 'percurso', path: '/percurso', component: Percurso },
    { name: 'startlist', path: '/startlist', component: StartList },
    { name: 'organizacao', path: '/organizacao', component: Organizacao },
    { name: 'comochegar', path: '/comochegar', component: ComoChegar },
    { name: 'cronograma', path: '/cronograma', component: Cronograma },
    { name: 'alojamento', path: '/alojamento', component: Alojamento },
    { name: 'cancelamento', path: '/cancelamento', component: Cancelamento },
    { name: 'regulamentos', path: '/regulamentos', component: Regulamentos },
    { name: 'inscricao', path: '/inscricao', component: Inscricao },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
            return new Promise((resolve) => {
                setTimeout(() => {
                    resolve({ el: to.hash, behavior: 'smooth', top: 50 });
                }, 100); // Adjust the timeout as necessary
            });
        }
        return { behavior: 'smooth', top: 0 };  // Go to the top of the page if no hash
    },
})

export default router;