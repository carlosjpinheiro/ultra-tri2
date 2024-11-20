import Inscricao from './components/Inscricao.vue'
import Regulamentos from './components/Regulamentos.vue'
import Cancelamento from './components/Cancelamento.vue'
import Alojamento from './components/Alojamento.vue'
import Cronograma from './components/Cronograma.vue'

import Home from './components/Home.vue'
import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    { name: 'home', path: '/', meta: { name: 'home' }, component: Home, },
    { name: 'sobre', path: '/sobre', meta: { name: 'Sobre'} , redirect: { name: 'home', hash: '#sobre' }},
    { name: 'modalidades', path: '/modalidades', meta: { name: 'Modalidades'} , redirect: { name: 'home', hash: '#modalidades' }},
    { name: 'arete', path: '/arete', meta: { name: 'Arete'} , redirect: { name: 'home', hash: '#arete' }},
    { name: 'contato', path: '/contato', meta: { name: 'Contato'} , redirect: { name: 'home', hash: '#contato' }},
    { name: 'valores', path: '/valores', meta: { name: 'Valores'} , redirect: { name: 'home', hash: '#valores' }},
    
    
    { name: 'cronograma', path: '/cronograma', component: Cronograma},
    { name: 'alojamento', path: '/alojamento', component: Alojamento},
    { name: 'cancelamento', path: '/cancelamento', component: Cancelamento},
    { name: 'regulamentos', path: '/regulamentos', component: Regulamentos },
    { name: 'inscricao', path: '/inscricao', component: Inscricao },
]
  
const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior (to, from, savedPosition) {
        if (to.hash) {
            return new Promise((resolve) => {
                setTimeout(() => {
                    resolve({ el: to.hash, behavior: 'smooth', top:50 });
                }, 100); // Adjust the timeout as necessary
            });
        }
        return { behavior: 'smooth', top: 0 };  // Go to the top of the page if no hash
    },
})

export default router;