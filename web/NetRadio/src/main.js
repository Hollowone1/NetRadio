import './assets/main.scss'

import {createApp} from 'vue'
import {createPinia} from 'pinia'
import piniaPersist from 'pinia-plugin-persist'

import App from './App.vue'
import router from './router'
import api from '@/plugin/api.js'

import 'v-calendar/style.css';
import VCalendar from 'v-calendar';



const app = createApp(App)
const pinia = createPinia()
app.use(pinia)
pinia.use(piniaPersist)
app.use(router)
app.use(api)
app.use(VCalendar, {})
app.mount('#app')

