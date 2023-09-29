import './bootstrap';
import { createApp } from 'vue';
import routes from './routes';
import EventBus from './src/eventBus.js';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const login    = createApp({});
const index    = createApp({});
const homePage = createApp({});

login.use(routes).mount('#login');
index.use(routes).mount('#index');
homePage.use(routes).mount('#homePage');

login.use(VueSweetalert2); 
index.use(VueSweetalert2);
// user section
homePage.use(VueSweetalert2); 

login.use(EventBus); 
index.use(EventBus);
homePage.use(EventBus);