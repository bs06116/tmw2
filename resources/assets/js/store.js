import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import router from "./routes"
import createPersistedState from 'vuex-persistedstate'


Vue.use(Vuex)

const store=new Vuex.Store({
    state: {
        status: '',
        token: localStorage.getItem('token') || '',
        user : {},
        isLoggedIn:false
    },
    mutations: {
        setLogged(state, name) {
            state.isLoggedIn = name;
        },
    },
    actions: {
        setLogged({ commit }, name) {
            commit('setLogged', name);
        },
    },
    getters : {
        getLogged: state => {
            return state.isLoggedIn
        }
    },
    plugins: [createPersistedState()]
})
export  default store;