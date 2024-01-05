import types from './types.js'

const state = {
    posts: [],
    page: 1
}

const mutations = {
    [types.SET_POSTS](state, payload) {
        state.posts = payload.posts
        state.page = payload.page
    }
}

const actions = {
    async [types.GET_POSTS]({commit}, payload) {
        const response = await axios.get('api/posts', {
            params: {
                slug: payload.slug,
                page: payload.page
            }
        })
        commit(types.SET_POSTS, response.data.data)
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions
}
