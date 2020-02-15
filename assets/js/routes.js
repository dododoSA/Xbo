import Vue from 'vue';
import VueRouter from 'vue-router';

import HomePage from './pages/HomePage';
import LoginPage from './pages/LoginPage';
import RegisterPage from './pages/RegisterPage';
import HouseholdPage from './pages/HouseholdPage';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes:[
        { path: '/', name: 'home', component: HomePage },
        { path: '/login', name: 'login', component: LoginPage },
        { path: '/register', name: 'register', component: RegisterPage },
        { path: '/household', name: 'household', component: HouseholdPage }
    ]
});

export default router;