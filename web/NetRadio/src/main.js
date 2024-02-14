import './assets/main.scss'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import api from '@/plugin/api.js'
import 'v-calendar/style.css';
import VCalendar from 'v-calendar';


import App from './App.vue'
import router from './router'

const app = createApp(App)
app.use(VCalendar, {})

app.use(createPinia())
app.use(router)
app.use(api)
app.mount('#app')
