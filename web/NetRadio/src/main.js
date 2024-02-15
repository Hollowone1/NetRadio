import './assets/main.scss'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'


import { createPinia } from 'pinia'
import piniaPersist from 'pinia-plugin-persist'
const pinia = createPinia()
pinia.use(piniaPersist)

import api from '@/plugin/api.js'

import 'v-calendar/style.css';
import VCalendar from 'v-calendar';



const app = createApp(App)
app.use(router)
app.use(pinia)
app.use(api)
app.use(VCalendar, {})
app.mount('#app')
