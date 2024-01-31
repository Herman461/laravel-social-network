import types from "./types.js";
import {http} from '../../js/axios.js'


const state = {
    tags: []
}

const mutations = {

    [types.SET_TAGS](state, payload) {
        state.tags = payload
    },

}

const actions = {
    async [types.GET_TAGS]({commit}) {
        const response = await http.get("home/tags/trending")
        console.log(response)
        commit(types.SET_TAGS, response.data)
    },



}

export default {
    namespaced: true,
    state,
    mutations,
    actions
}
