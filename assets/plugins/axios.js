import Vue from 'vue';
import axios from 'axios';

Vue.prototype.$axios = axios.create({
    headers:{
        'X-Requested-With': 'XMLHttpRequest'
    }
});