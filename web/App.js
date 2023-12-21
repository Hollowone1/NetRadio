import { createApp } from "vue";

import entete from './app/components/entete.js';
import navBar from './app/components/navBar.js';
import basPage from './app/components/basPage.js';
import direct from "./app/components/direct";

window.addEventListener('load', () => {
    Vue.createApp({
        components: {
            entete,
            navBar,
            direct,
            basPage
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
