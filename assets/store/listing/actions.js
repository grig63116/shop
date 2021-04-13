export default {
    getListing ({ commit }, params) {

        return this.$axios.get(this.$appConfig.routes.product_list, { params })
            .then(({ data }) => {
                commit('SET_PRODUCTS', data.products);
                commit('SET_PAGE', data.page);
                commit('SET_PER_PAGE', data.perPage);
                commit('SET_TOTAL', data.total);
            });
    }
}
