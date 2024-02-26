import axios from 'axios';
import { useUserStore } from '@/stores/user.js'

export default {

    install: function (app) {
        app.config.globalProperties.$api = axios.create({
            baseURL : 'http://localhost:2080',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': "Bearer " + useUserStore().tokens.access_token
            },
        })
    }
}

export const $api = axios.create({
    baseURL: 'http://localhost:2080',
    headers: {
        'Content-Type': 'application/json',
    },
});