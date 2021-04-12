<template>
  <b-card
      v-if="product"
      no-body
      tag="article"
      align="center"
  >
    <div class="product-image">
      <b-card-img-lazy
          class="w-100 h-100"
          :src="image"
          :alt="product.name"></b-card-img-lazy>
    </div>
    <b-card-body>
      <b-card-title
          class="product-title mb-2"
          :title="product.name"
          v-line-clamp="2"></b-card-title>
      <b-card-sub-title class="mb-2">
        <small>
          <strong>Number: </strong>
          <span>{{ product.number }}</span>
        </small>
      </b-card-sub-title>
      <b-card-text>
        <p class="product-description mb-2" v-line-clamp="3">{{ product.description }}</p>
        <p class="product-price mb-2">{{ product.price|currency }}</p>
      </b-card-text>
      <b-button variant="primary" @click.stop.prevent="addToCart(product.number)">Add to cart</b-button>
    </b-card-body>
  </b-card>
</template>

<script>
import { mapActions } from "vuex";
import loaderMixin from '@/mixins/loader';

export default {
  mixins: [loaderMixin],
  props: {
    product: {
      type: Object,
      required: true
    }
  },
  computed: {
    image () {
      if (this.product.image) {
        return `/media/${this.product.image}`;
      }
      return require('@/images/no-picture.svg');
    }
  },
  methods: {
    ...mapActions({ refreshCart: 'cart/getTotalCount' }),
    async addToCart (number) {
      this.showLoader();

      return await this.$axios.post(this.$appConfig.routes.cart_add, {
        number
      })
          .then(() => {
            this.$toast.success('Product was successfully added to cart.');
            this.$scrollTo(this.$root.$el);
            this.refreshCart();
            this.$nextTick(this.hideLoader);
          })
          .catch(error => {
            this.$toast.error('An error has occurred.');
            this.$nextTick(this.hideLoader);
          });
    }
  },
  mounted: function () {
    this.$nextTick().then(() => {
      this.$emit('ready');
    });
  }
}
</script>

<style lang="scss" scoped>
.product-image {
  height: 15rem;

  img {
    object-fit: contain;
  }
}

.product-title {
  height: 2.5em;
  line-height: 1.2;
}

.product-description {
  height: 3.7em;
  line-height: 1.2;
}
</style>