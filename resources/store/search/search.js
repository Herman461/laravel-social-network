import types from './types'

const mutations = {
    [types.ACTIVATE_IS_LOADING](state) {
        state.isLoading = true
    },
    [types.DEACTIVATE_IS_LOADING](state) {
        state.isLoading = false
    },
    [types.SET_USERS](state, payload) {
        state.users = payload
    }
}

const state = {
    isLoading: false,
    users: {},
}

const actions = {
    async [types.INIT]({commit}) {
        commit(types.ACTIVATE_IS_LOADING)

        const response = await axios.get('api/search/random/users')

        commit(types.DEACTIVATE_IS_LOADING)
        commit(types.SET_USERS, response.data)
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions
}
