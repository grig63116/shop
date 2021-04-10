import Vue from 'vue';

Vue.prototype.$appConfig = $appConfig;

import '@/plugins/controllers';
import '@/plugins/bootstrap';
import '@/plugins/axios';
import '@/plugins/loading';
import '@/plugins/components';
import '@/plugins/pagination';
import '@/plugins/truncate';
import '@/plugins/scroll-to';
import '@/plugins/toast-notification';
import '@/filters/currency';
import '@/styles/app.scss';