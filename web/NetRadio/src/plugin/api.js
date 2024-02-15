import axios from 'axios';

export default {
    install: function (app) {
        app.config.globalProperties.$api = axios.create({
            baseURL : 'http://localhost:2080',
            headers: {
                'Content-Type': 'application/json',
            },
            crossDomain: true,
            withCredentials: true,
            xsrfCookieName: 'XSRF-TOKEN',
            xsrfHeaderName: 'X-XSRF-TOKEN',
        })
    }
}