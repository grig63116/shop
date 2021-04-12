export default {
    getCart ({ commit, dispatch, state }) {

        this.$axios.get('/checkout/cart/content').then((res) => {
            commit('SET_CART_DATA', res.data.data)
        })
    }
}
