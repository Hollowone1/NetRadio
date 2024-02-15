import axios from 'axios';

const axiosPlugin =  {
    install: function (app) {
        const axiosInstance = axios.create({
            baseURL : 'http://localhost:2080/',
            headers: {
                'Content-Type': 'application/json',
            }
        });

        app.config.globalProperties.$api = axiosInstance;
    }
}

export default axiosPlugin;