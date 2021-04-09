import Vue from 'vue';
import Utils from '@/utils'

const Truncate = function (text, length = 30, clamp = '...') {
    text = Utils.toString(text);
    return text.length > length ? text.slice(0, length) + clamp : text;
};

Vue.filter('truncate', Truncate);
