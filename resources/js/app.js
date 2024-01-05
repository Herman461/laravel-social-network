import './bootstrap';

import { createApp } from 'vue';

import AppComponent from './components/Pages/App.vue'
import store from "../store/store.js";
import router from "./routes.js";

const app = createApp(AppComponent)

app.use(store)
app.use(router)
app.mount("#app")
