import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        username: '',
        householdId: -1
    },
    getters: {

    },
    mutations: {
        setUserdata (state, userdata) {
            if (userdata !== null) {
                state.username = userdata['username'];
                state.householdId = userdata['household_id'];
            } else {
                state.username = '';
                state.householdId = -1;
            }
        },
    },
    actions: {
        //前ページ共通のロード
        getMe({commit}) {
            axios.get('/api/login_check')
                .then(res => {
                    commit('setUserdata', res.data)
                })
                .catch(err => {
                    console.log(err);
                    commit('setUserdata', null);
                });
        }
    }
})