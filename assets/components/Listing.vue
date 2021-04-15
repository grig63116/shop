<template>
  <div class="listing">
    <template v-if="productsCount">
      <ListingActions></ListingActions>
      <b-row class="my-3" align-content="between" align-v="stretch" cols="1" cols-md="2" cols-lg="3">
        <b-col class="my-3" v-for="(product,number) in products" :key="number">
          <Product class="h-100" :product="product" @ready="onProductReady"></Product>
        </b-col>
      </b-row>
      <ListingActions></ListingActions>
    </template>
    <b-alert variant="warning" :show="!isLoading && !productsCount">
      There is no any product to show!
    </b-alert>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import loaderMixin from '@/mixins/loader';

export default {
  mixins: [loaderMixin],
  data () {
    return {
      readyProducts: 0
    };
  },
  watch: {
    products () {
      this.readyProducts = 0;
    },
    readyProducts () {
      this.hideLoaderIfLoaded();
    },
    page () {
      this.asyncData();
    },
    perPage () {
      this.asyncData();
    }
  },
  computed: {
    ...mapGetters({
      products: 'listing/getProducts',
      page: 'listing/getPage',
      perPage: 'listing/getPerPage'
    }),
    productsCount () {
      if (this.products === null) {
        return 0;
      }
      return Object.keys(this.products).length;
    }
  },
  created () {
    this.asyncData();
  },
  methods: {
    ...mapActions({ getListing: 'listing/getListing' }),
    asyncData () {
      if (this.isLoading) {
        return;
      }
      this.showLoader();

      return this.getListing({
        page: this.page,
        perPage: this.perPage
      })
          .then(() => {
            this.$scrollTo(this.$el);
            this.$nextTick(this.hideLoaderIfLoaded);
          })
          .catch(error => {
            this.$toast.error('An error has occurred.');
            this.$nextTick(this.hideLoader);
          });
    },
    onProductReady () {
      this.readyProducts++;
    },
    hideLoaderIfLoaded () {
      if (this.productsCount === this.readyProducts) {
        this.hideLoader();
      }
    }
  }
}
</script>