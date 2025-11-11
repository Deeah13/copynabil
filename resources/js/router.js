// resources/js/router.js (CONTOH)

import { createRouter, createWebHistory } from 'vue-router';
import LandingPage from './Pages/LandingPage.vue';
// import LoginPage from './Pages/LoginPage.vue'; (Nanti)

const routes = [
    {
        path: '/',
        name: 'landing',
        component: LandingPage 
    },
    // { path: '/login', component: LoginPage },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;