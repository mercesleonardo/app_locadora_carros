// src/store/index.js
import { createStore } from 'vuex';

export default createStore({
    state: {
        item: null, // Inicialmente, item é nulo
        transacao: { status: '', mensagem: '', dados: '' },
    },
    mutations: {
        setItem(state, obj) {
            state.item = obj; // Mutation para definir o estado de item
            state.transacao.status = '';
            state.transacao.mensagem = '';
        },
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
