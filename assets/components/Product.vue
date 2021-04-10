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
export default {
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
    async addToCart (number) {
      let loader = this.$loading.show();

      return await this.$axios.get(this.$appConfig.routes.add_to_cart, {
        params: { number }
      })
          .then(() => {
            this.$root.$emit('refresh-cart');
            this.$toast.success('Product was successfully added to cart.');
            this.$scrollTo(this.$root.$el);
            this.$nextTick(loader.hide);
          })
          .catch(error => {
            this.$toast.error('An error has occurred while adding product to cart.');
            this.$nextTick(loader.hide);
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