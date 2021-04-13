export default {
    getTotalCount ({ commit }) {
        commit('SET_IS_LOADING', true);
        return this.$axios.get(this.$appConfig.routes.cart_total_count)
            .then(({ data }) => {
                commit('SET_TOTAL_COUNT', data);
                commit('SET_IS_LOADING', false);
            });
    }
}
