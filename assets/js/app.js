import Vue from 'vue';
import Routes from './routes.js';

import App from './views/App';

const app = new Vue({
    el: '#app',
    router: Routes,
    render: h => h(App),
});

export default app;