//require('./bootstrap');
import Vue from 'vue'
import router from './router.js'
import store from './store.js'
import App from './pages/App.vue'

new Vue({
    el: '#app',
    router,
    store,
    components: {
        App
    }
});
