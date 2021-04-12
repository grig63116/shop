export default {
    SET_CART_DATA (state, item) {
        state.cartItems = item.lineItems
    }
}