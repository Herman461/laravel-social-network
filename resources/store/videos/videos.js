import types from "./types.js";
import {http} from '../../js/axios.js'

import router from "../../js/routes.js";
import {deleteCookie} from "../../js/helpers.js";
import store from "../store.js";

const state = {
    videos: [],
    allowSound: false,
    videoSpeed: 1.0,
    isFullscreen: false,
    lastPage: null,
    isCommentsOpened: false
}

const mutations = {
    [types.TOGGLE_IS_COMMENTS_OPENED](state) {
        state.isCommentsOpened = !state.isCommentsOpened
    },
    [types.TOGGLE_IS_LOADING](state) {
      state.isLoading = !state.isLoading
    },


    [types.SET_VIDEOS](state, payload) {
        state.videos.push(...payload)
    },
    [types.SET_COMMENTS](state, payload) {
        state.videos[payload.index].comments.push(...payload.comments)
    },
    [types.TOGGLE_SOUND](state) {
        state.allowSound = !state.allowSound
    },
    [types.UPDATE_VIDEO_SPEED](state, payload) {
        state.videoSpeed = payload.videoSpeed
    },
    [types.TOGGLE_IS_FULLSCREEN](state) {
        state.isFullscreen = !state.isFullscreen
    },
    [types.SET_LAST_PAGE](state, payload) {
        state.lastPage = payload
    }

}

const actions = {


    async [types.GET_VIDEOS]({commit, state}, payload) {

        const response = await http.get(`videos/${store.state.profile.user.id}`, {
            params: {
                'per-page': payload.perPage,
                page: payload.page,
            }

        })

        if (response.status === 200) {
            commit(types.SET_VIDEOS, response.data.data)

            if (!state.lastPage) {
                commit(types.SET_LAST_PAGE, response.data.meta.last_page)
            }
        }

    },

    [types.INCREMENET_VIEWS]({}, payload) {
        http.patch(`videos/views/${payload.videoId}`)
    },

    async [types.UPLOAD_COMMENTS]({commit, state}, payload) {
        const response = await http.get(`videos/comments/${payload.videoId}`, {
            params: {
                'per-page': payload.perPage,
                page: payload.page,
            }
        })
        console.log(response)
        if (response.status === 200) {

            commit(types.SET_COMMENTS, {index: payload.index, comments: response.data.data});
        }

    },
}

export default {
    namespaced: true,
    state,
    mutations,
    actions
}
