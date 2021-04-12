import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vuex.Store.prototype.$axios = axios.create({
    headers: {
        'X-Requested-With': 'XMLHttpRequest'
    }
});
Vuex.Store.prototype.$appConfig = $appConfig;
Vue.use(Vuex);