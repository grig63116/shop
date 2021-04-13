export default {
    SET_PRODUCTS (state, products) {
        state.products = products;
    },
    SET_PAGE (state, page) {
        state.page = page;
    },
    SET_PER_PAGE (state, perPage) {
        state.perPage = perPage;
    },
    SET_TOTAL (state, total) {
        state.total = total;
    }
}