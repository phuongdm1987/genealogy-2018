import tree from '../../api/tree'

// initial state
const state = {
    type: 'tree',
    layoutType: 'euclidean',
    duration: 750,
    Marginx: 30,
    Marginy: 30,
    radius: 5,
    nodeText: 'full_name',
    currentNode: null,
    zoomable: true,
    isLoading: false,
    events: [],
    treeData: null,
};

// getters
const getters = {
    personDetail: (state, getters, rootState) => {
        return rootState.person.detail
    },
};

// actions
const actions = {
    getTree ({ commit }) {
        tree.getTree().then((response) => {
            commit('setTree', response.data.data)
        })
        .catch((error => {
            console.log(error.statusText);
        }));
    },
    setCurrentNode ({dispatch, commit}, node) {
        commit('setCurrentNode', node);
        dispatch('toggleShowModal', null, {root: true});
        dispatch('person/getDetail', node.data.id, {root: true})
    },
    resetCurrentNode ({dispatch, commit}) {
        commit('setCurrentNode', null);
        dispatch('toggleShowModal', null, {root: true});
    },
    setLoading ({commit, state}, status) {
        commit('isLoading', status)
    },
    appendEvent ({commit, state}, event) {
        commit('appendEvent', event)
    },
    updateCurrentNodeData({commit, state}, data) {
        commit('updateCurrentNodeData', data)
    }
};

// mutations
const mutations = {
    setTree (state, tree) {
        state.treeData = tree
    },
    setCurrentNode (state, node) {
        state.currentNode = node
    },
    setLoading (state, status) {
        state.isLoading = status
    },
    appendEvent (state, event) {
        state.events.push(event)
    },
    updateCurrentNodeData (state, data) {
        state.currentNode.data = data
    }
    // decrementProductInventory (state, { id }) {
    //     const product = state.all.find(product => product.id === id)
    //     product.inventory--
    // }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
