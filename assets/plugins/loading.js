import Vue from 'vue';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

Vue.component('loading', Loading);
Vue.use(Loading, {
    color: '#189EFF'
});