export default {
    SET_CART (state, cart) {
        state.cart = cart;
    },
    SET_TOTAL_COUNT (state, totalCount) {
        state.totalCount = totalCount;
    },
    SET_IS_LOADING (state, isLoading) {
        state.isLoading = isLoading;
    }
}