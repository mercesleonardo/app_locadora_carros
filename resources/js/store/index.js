// src/store/index.js
import { createStore } from 'vuex';

export default createStore({
    state: {
        teste: 'Teste de vuex'
    },
    mutations: {
        setTeste(state, payload) {
            state.teste = payload;
        }
    },
    actions: {
        increment({ commit }) {
            commit('increment');
        },
        decrement({ commit }) {
            commit('decrement');
        }
    },
    getters: {
        count: (state) => state.count
    }
});
