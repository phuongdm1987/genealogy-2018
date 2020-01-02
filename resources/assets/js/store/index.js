import Vue from 'vue'
import Vuex from 'vuex'
import tree from './modules/tree'
import person from './modules/person'
import createLogger from '../plugins/logger'

Vue.use(Vuex); 

const debug = process.env.NODE_ENV !== 'production';

const state = {
    showModal: false,
    showForm: false
};

// actions
const actions = {
    toggleShowModal ({ commit, state }) {
        commit('updateShowModal', !state.showModal);
    },
    toggleShowForm ({ commit, state }) {
        commit('updateShowForm', !state.showForm);
    }
};

// mutations
const mutations = {
    updateShowModal (state, showModal) {
        state.showModal = showModal;
    },
    updateShowForm (state, showForm) {
        state.showForm = showForm;
    }
};

export default new Vuex.Store({
    modules: {
        tree,
        person
    },
    state,
    actions,
    mutations,
    strict: false,
    plugins: debug ? [createLogger()] : []
})
