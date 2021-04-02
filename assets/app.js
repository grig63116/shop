import '@/bootstrap';
import '@/components';
import '@/styles/app.scss';
import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import VueRouter from 'vue-router';

Vue.prototype.$appConfig = $appConfig;
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueRouter);
