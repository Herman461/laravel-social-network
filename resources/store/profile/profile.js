import types from "./types.js";
import {http} from '../../js/axios.js'

import router from "../../js/routes.js";
import {deleteCookie} from "../../js/helpers.js";

const state = {
    user: {},
    isAuth: false,
    isLoading: false
}

const mutations = {
    [types.SET_AVATAR](state, payload) {
        state.user.avatar = payload
    },
    [types.SET_BANNER](state, payload) {
        state.user.banner = payload
    },
    [types.SET_USER](state, payload) {
        state.user = payload
    },
    [types.TOGGLE_IS_LOADING](state) {
      state.isLoading = !state.isLoading
    },
    [types.SET_IS_AUTH](state, payload) {
        state.isAuth = payload
    }
}

const actions = {
    async [types.UPDATE_AVATAR]({commit}, payload) {
        const response = await http.post('profile/upload/avatar', payload)

        commit(types.SET_AVATAR, response.data.avatar)
    },

    async [types.UPDATE_BANNER]({commit}, payload) {
        const response = await http.post('profile/upload/banner', payload)

        commit(types.SET_BANNER, response.data.banner)
    },

    async [types.UPLOAD_USER]({commit, state}, payload) {
        try {
            commit(types.TOGGLE_IS_LOADING)

            const response = await http.get(`profile/user/${payload.slug}`)

            if (!response.data.user) {
                router.push('/')
                return
            }

            commit(types.SET_USER, response.data.user)
            commit(types.SET_IS_AUTH, response.data.isAuth)
            commit(types.TOGGLE_IS_LOADING)
        } catch (e) {
            router.push('/login')
            deleteCookie('access_token')
        }

    },
}
export default {
    namespaced: true,
    state,
    mutations,
    actions
}
