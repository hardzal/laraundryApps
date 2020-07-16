//require('./bootstrap');
import Vue from 'vue'
import router from './router.js'
import store from './store.js'
import App from './pages/App.vue'
import BootstrapVue from 'bootstrap-vue'
import VueSweetalert2 from 'vue-sweetalert2'
import Permission from './mixins/permission.js'

Vue.use(VueSweetalert2)
Vue.use(BootstrapVue)
Vue.mixin(Permissions)

import 'bootstrap-vue/dist/bootstrap-vue.css'
import {
    mapActions,
    mapGetters
} from 'vuex'

new Vue({
    el: '#app',
    router,
    store,
    components: {
        App
    },
    computed: {
        ...mapGetters(['isAuth'])
    },
    methods: {
        ...mapActions('user', ['getUserLogin'])
    },
    created() {
        if (this.isAuth) {
            this.getUserLogin()
        }
    }

});
