import { createApp } from "vue";

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const app = createApp();

app.component('VueDatePicker', VueDatePicker);
app.component('navbar', './components/nav.js');
app.component('footer', './components/footer.js');
app.component('header', './components/header.js');


app.mount('#app');