import types from "./types.js";
import {getCookie, setCookie} from "../../js/helpers.js";
import {http} from '../../js/axios.js'
import router from "../../js/routes.js";

const state = {
    user: {}
}

const mutations = {
    [types.SET_USER](state, payload) {
        state.user = payload
    }
}

const actions = {
    async [types.LOGIN]({commit}, payload) {
        const response = await http.post('auth/login', payload)

        setCookie('access_token', response.data.access_token, {'max-age:': 3600})
        commit(types.SET_USER, response.data.user)
    },
    async [types.GET_USER]({commit}) {
        const token = getCookie('access_token')

        if (!token) return

        const response = await http.get('auth/get')

        setCookie('access_token', response.data.access_token, {'max-age:': 3600})
        commit(types.SET_USER, response.data.user)

        router.push('/profile')
    }
}
export default {
    namespaced: true,
    state,
    mutations,
    actions
}
