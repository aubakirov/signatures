require('./bootstrap');

import Vue from 'vue'
import Vuelidate from 'vuelidate'
import VueMoment from 'vue-moment'

import { BootstrapVue, IconsPlugin} from 'bootstrap-vue'

Vue.use(Vuelidate)
Vue.use(VueMoment)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)


import Order from './components/Order'
import Signatures from './components/Signatures'

const app = new Vue({
    el: '#app',
    components: {Order, Signatures}
})
