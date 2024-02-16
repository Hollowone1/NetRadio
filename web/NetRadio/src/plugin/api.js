import axios from 'axios';

export default {
    install: function (app) {
        app.config.globalProperties.$api = axios.create({
            baseURL : 'http://localhost:2080',
            headers: {
                'Content-Type': 'application/json',
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