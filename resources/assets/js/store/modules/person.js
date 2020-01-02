import person from '../../api/person'

// initial state
const state = {
    detail: null,
};

// getters
const getters = {};

// actions
const actions = {
    getDetail ({ dispatch, commit, state }, personId) {
        person.detail(personId).then((response) => {
            commit('setDetail', response.data.data);
            dispatch('tree/updateCurrentNodeData', response.data.data, {root: true})
        }).catch((error => {
            console.log(error.statusText);
        }));
    },
    update ({dispatch, commit, state}, personData) {
        person.update(personData.id, personData).then((response) => {
            commit('setDetail', personData);
            dispatch('toggleShowForm', null, {root: true});
        }).catch((error => {
            console.log(error.statusText);
        }));
    }
};

// mutations
const mutations = {
    setDetail (state, detail) {
        state.detail = detail;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
