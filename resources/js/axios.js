import {getCookie} from "./helpers.js";

const headers = {
    'Accept': 'application/json',
}

const token = getCookie('access_token')

if (token) {
    headers['Authorization'] = 'Bearer ' + token
}

const http = axios.create({
    baseURL: '/api/',
    headers
})

export {http}
