import './bootstrap';
import {createApp} from "vue";
import Icons from './icons/Icons.vue'

const app = createApp({});

app.component('icon', Icons)

app.mount('#app');
