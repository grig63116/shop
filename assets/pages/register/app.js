import Vue from 'vue';
import App from './index.vue';
import store from '@/store';

new Vue({
    render: h => h(App),
    store
}).$mount('#app');