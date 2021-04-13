import Vuex from "vuex";
import cart from "./cart";
import listing from "./listing";

export default new Vuex.Store({
    modules: {
        cart,
        listing
    }
});