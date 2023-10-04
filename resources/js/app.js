/**
 * Vue
 */
import { createApp } from 'vue'
import axios from 'axios'
import moment from 'moment'
import globalMixin from "./mixins"
import vSelect from "vue-select";

// Vue.component("v-select", vSelect);

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import 'vue-select/dist/vue-select.css';

window.axios = axios
window.moment = moment

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'Authorization': document.querySelector('meta[name="authorization"]').getAttribute('content'),
}


/**
 * Parts of page
 */
import IconSvg from './components/IconSvg.vue'
import HomePage from './admin/HomePage.vue'
import CreateOrEditProduct from './admin/CreateOrEditProduct.vue'
import PopUpModal from './admin/PopUpModal.vue'

const app = createApp({
    components: {
        IconSvg,
        HomePage,
        CreateOrEditProduct,
        PopUpModal
    },
});

app.mixin( globalMixin )

app.mount('#app')

