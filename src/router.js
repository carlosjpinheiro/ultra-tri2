import Inscricao from './components/Inscricao.vue'
import Regulamentos from './components/Regulamentos.vue'

import Home from './components/Home.vue'
import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    { name: 'home', path: '/', meta: { name: 'home' }, component: Home, },
    { name: 'sobre', path: '/sobre', meta: { name: 'Sobre'} , redirect: { name: 'home', hash: '#sobre' }},
    { name: 'contato', path: '/contato', meta: { name: 'Contato'} , redirect: { name: 'home', hash: '#contato' }},

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
                    resolve({ el: to.hash, behavior: 'smooth' });
                }, 100); // Adjust the timeout as necessary
            });
        }
        return { behavior: 'smooth', top: 0 };  // Go to the top of the page if no hash
    },
})

export default router;