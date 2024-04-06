import './bootstrap';
import "primevue/resources/themes/saga-green/theme.css";
import 'primeicons/primeicons.css';
import 'sweetalert2/dist/sweetalert2.min.css';

import VueSweetalert2 from 'vue-sweetalert2';
import PrimeVue from "primevue/config";
import Tooltip from 'primevue/tooltip';

import Home from './components/Home.vue';
import Dashboard from './components/Dashboard.vue';

import { createApp } from "vue";

const app = createApp(Home);

app
    .use(PrimeVue, { ripple: true })
    .use(VueSweetalert2)
    .directive('tooltip', Tooltip);

app.mount(`#app`); 


//dashboard
const appDashboard = createApp(Dashboard);

appDashboard
    .use(PrimeVue, { ripple: true })
    .use(VueSweetalert2)
    .directive('tooltip', Tooltip);

appDashboard.mount(`#dashboard`); 


