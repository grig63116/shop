import Vue from 'vue';

Vue.prototype.$appConfig = $appConfig;

import '@/plugins/controllers';
import '@/plugins/bootstrap';
import '@/plugins/axios';
import '@/plugins/loading';
import '@/plugins/components';
import '@/plugins/pagination';
import '@/filters/currency';
import '@/filters/truncate';
import '@/styles/app.scss';