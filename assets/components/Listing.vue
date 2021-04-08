<template>
  <div class="listing">
    <ListingActions
        :currentPage="page"
        :pagesCount="pages"
        :perPageCount="perPage"
        @changePage="changePage"
        @changePerPage="changePerPage"></ListingActions>
    <b-row v-if="products" class="my-3">
      <b-col v-for="(product,number) in products" :key="number">
        <Product :product="product"></Product>
      </b-col>
    </b-row>
    <ListingActions
        :currentPage="page"
        :pagesCount="pages"
        :perPageCount="perPage"
        @changePage="changePage"
        @changePerPage="changePerPage"></ListingActions>
  </div>
</template>

<script>
export default {
  data () {
    return {
      products: null,
      page: 3,
      perPage: 9,
      total: 0
    }
  },
  computed: {
    pages () {
      return Math.ceil(this.total / this.perPage);
    }
  },
  created () {
    this.asyncData();
  },
  methods: {
    async asyncData () {
      let loader = this.$loading.show();

      return await this.$axios.get(this.$appConfig.routes.product_list, {
        params: {
          page: this.page,
          perPage: this.perPage
        }
      })
          .then(({ data }) => {
            this.products = data.products;
            this.page = data.page;
            this.perPage = data.perPage;
            this.total = data.total;
            this.$nextTick(loader.hide);
          })
          .catch(error => {
            this.$nextTick(loader.hide);
          });
    },
    changePage (page) {
      this.page = page;
      this.asyncData();
    },
    changePerPage (perPage) {
      this.perPage = perPage;
      this.asyncData();
    }
  },
}
</script>

<style lang="scss" scoped>

</style>