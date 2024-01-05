import Profile from './components/Pages/Profile.vue'
import Messenger from './components/Pages/Messenger.vue'
import {createRouter, createWebHistory} from 'vue-router'

const routes = [
    { path: '/profile/:slug?', component: Profile },
    { path: '/im', component: Messenger },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
