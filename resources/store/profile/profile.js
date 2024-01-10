import types from "./types.js";
import {http} from '../../js/axios.js'

import router from "../../js/routes.js";
import {deleteCookie} from "../../js/helpers.js";

const state = {
    user: {},
    isFollower: false,
    canEditProfile: false,
    isLoading: false
}

const mutations = {
    [types.SET_AVATAR](state, payload) {
        state.user.avatar = payload
    },
    [types.SET_BANNER](state, payload) {
        state.user.banner = payload
    },
    [types.INCREMENET_FOLLOWERS](state) {
        state.user.followers_count += 1
    },
    [types.DECREMENET_FOLLOWERS](state) {
        state.user.followers_count -= 1
    },
    [types.SET_USER](state, payload) {
        state.user = payload
    },
    [types.TOGGLE_IS_LOADING](state) {
      state.isLoading = !state.isLoading
    },
    [types.SET_IS_AUTH](state, payload) {
        state.canEditProfile = payload
    },
    [types.SET_IS_FOLLOWER](state, payload) {
        state.isFollower = payload
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

            console.log(response)
            if (!response.data.user) {
                // router.push('/')
                return
            }

            commit(types.SET_USER, response.data.user)
            commit(types.SET_IS_AUTH, response.data.canEditProfile)
            commit(types.SET_IS_FOLLOWER, response.data.isFollower)
            commit(types.TOGGLE_IS_LOADING)
        } catch (e) {

            // if (e.response.status === 401) {
            //     router.push('/login')
            // }
            deleteCookie('access_token')
        }

    },
    async [types.FOLLOW]({commit, state}) {
        const response = await http.post(`profile/follow/${state.user.id}`)

        if (response.status === 200) {
            commit(types.INCREMENET_FOLLOWERS);
            commit(types.SET_IS_FOLLOWER, response.data.isFollower);
        }

    },
    async [types.UNFOLLOW]({commit, state}) {
        const response = await http.post(`profile/unfollow/${state.user.id}`)

        if (response.status === 200) {
            commit(types.DECREMENET_FOLLOWERS);
            commit(types.SET_IS_FOLLOWER, response.data.isFollower);
        }
    },
}
export default {
    namespaced: true,
    state,
    mutations,
    actions
}
