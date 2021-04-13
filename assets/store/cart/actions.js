export default {
    getCart ({ commit }) {
        return this.$axios.get(this.$appConfig.routes.cart_content)
            .then(({ data }) => {
                commit('SET_CART', data);
            });
    },
    getTotalCount ({ commit }) {
        commit('SET_IS_LOADING', true);
        return this.$axios.get(this.$appConfig.routes.cart_total_count)
            .then(({ data }) => {
                commit('SET_TOTAL_COUNT', data);
                commit('SET_IS_LOADING', false);
            });
    }
}
