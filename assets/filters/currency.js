import Vue from 'vue';
import Utils from '@/utils'

const Currency = function (price, symbol = '$') {
    price = Utils.strReplaceAll(price, /,/, '.');
    if (!price) price = 0;
    price = parseFloat(price).toFixed(2);
    price = Utils.strReplaceAll(price, /\./, ',');

    if (symbol.length > 0) {
        price = [price];
        price.push(symbol);
        price = price.join(' ');
    }
    return price;
}

Vue.filter('currency', Currency);
