import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        username: ''
    },
    getters: {

    },
    mutations: {
        setUsername (state, username) {
            state.username = username;
        }
    },
    actions: {
        getMe({commit}) {
            axios.get('/api/login_check')
                .then(res => {
                    commit('setUsername', res.data)
                })
                .catch(err => {
                    console.log(err);
                    commit('setUsername', '');
                });
        }
    }
})