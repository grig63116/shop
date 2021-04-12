<template>
  <div class="listing">
    <template v-if="this.productsCount">
      <ListingActions
          :currentPage="page"
          :pagesCount="pages"
          :perPageCount="perPage"
          @changePage="changePage"
          @changePerPage="changePerPage"></ListingActions>
      <b-row class="my-3" alignh="between" align-v="stretch" cols="3">
        <b-col class="my-3" v-for="(product,number) in products" :key="number">
          <Product class="h-100" :product="product" @ready="onProductReady"></Product>
        </b-col>
      </b-row>
      <ListingActions
          :currentPage="page"
          :pagesCount="pages"
          :perPageCount="perPage"
          @changePage="changePage"
          @changePerPage="changePerPage"></ListingActions>
    </template>
    <b-alert variant="warning" :show="!loader || (!loader.isActive && !productsCount)">
      There is no any product to show!
    </b-alert>
  </div>
</template>

<script>
export default {
  data () {
    return {
      loader: null,
      products: null,
      readyProducts: 0,
      page: 3,
      perPage: 9,
      total: 0
    }
  },
  watch: {
    products () {
      this.readyProducts = 0;
    },
    readyProducts () {
      this.hideLoaderIfLoaded();
    }
  },
  computed: {
    productsCount () {
      if (this.products === null) {
        return 0;
      }
      return Object.keys(this.products).length;
    },
    pages () {
      return Math.ceil(this.total / this.perPage);
    }
  },
  created () {
    this.asyncData();
  },
  methods: {
    async asyncData () {
      this.loader = this.$loading.show();

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
            this.$scrollTo(this.$el);
            this.$nextTick(this.hideLoaderIfLoaded);
          })
          .catch(error => {
            this.$toast.error('An error has occurred.');
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
    },
    onProductReady () {
      this.readyProducts++;
    },
    hideLoaderIfLoaded () {
      if (this.productsCount === this.readyProducts) {
        this.loader.hide();
      }
    }
  }
}
</script>

<style lang="scss" scoped>

</style>