import types from "./types.js";
import {getCookie, setCookie} from "../../js/helpers.js";
import {http} from '../../js/axios.js'
import router from "../../js/routes.js";

const state = {}

const mutations = {}

const actions = {
    async [types.LOGIN]({commit}, payload) {
        const response = await http.post('auth/login', payload)

        setCookie('access_token', response.data.access_token, {'max-age:': 3600})
        http.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.access_token

        router.push('/profile')
    },

}
export default {
    namespaced: true,
    state,
    mutations,
    actions
}
