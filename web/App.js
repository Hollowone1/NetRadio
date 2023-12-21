import { createApp } from "vue";

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import header from './app/components/header.js';
import navbar from './app/components/nav.js';
import footer from './app/components/footer.js';
import direct from "./app/components/direct";
app.component('VueDatePicker', VueDatePicker);




window.addEventListener('load', () => {
    Vue.createApp({
        components: {
            header,
            navbar,
            direct,
            footer
        },
        data() {
        return {
            message: "Hello World !",
            }
        },
        methods : {
            headerConnexion() {
                const burgerIcon = document.querySelector('.icon i');
                const myLinks = document.getElementById('myLinks');


                if (myLinks.style.display === 'block') {
                    burgerIcon.classList.add('gg-menu');
                    myLinks.style.display = 'none';
                } else {
                    myLinks.style.display = 'block';
                    burgerIcon.classList.add('gg-close');
                }
            }
        }
    }).mount('#app');
});
