import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './pages/Home';
import Login from './pages/Login';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes:[
        { path: '/', name: 'home', component: Home },
        { path: '/login', name: 'login', component: Login }
    ]
});

export default router;