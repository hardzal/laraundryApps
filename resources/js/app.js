//require('./bootstrap');
import Vue from 'vue'
import router from './router.js'
import store from './store.js'
import App from './pages/App.vue'
import BootstrapVue from 'bootstrap-vue'
import VueSweetalert2 from 'vue-sweetalert2'


new Vue({
    el: '#app',
    router,
    store,
    components: {
        App
    }
});

Vue.use(VueSweetalert2)
Vue.use(BootstrapVue)

import 'bootstrap-vue/dist/bootstrap-vue.css'
