<template>
  <b-nav>
    <b-nav-item
        link-classes="shop-nav-link"
        active-class="text-primary"
        :href="$appConfig.routes.account"
        title="Account">
      <b-icon-person font-scale="2"></b-icon-person>
    </b-nav-item>
    <b-nav-item
        link-classes="shop-nav-link position-relative"
        active-class="text-primary"
        :href="$appConfig.routes.cart"
        title="Cart">
      <b-spinner v-if="cartLoading" class="cart-loader"></b-spinner>
      <b-icon-cart3 v-else font-scale="1.7"></b-icon-cart3>
      <div class="cart-quantity bg-primary text-white text-center text-nowrap font-weight-bold rounded-circle">
        {{ cartQuantity }}
      </div>
    </b-nav-item>
  </b-nav>
</template>

<script>
export default {
  data () {
    return {
      cartLoading: false,
      cartQuantity: 0,
    }
  },
  methods: {
    refreshCart () {
      this.cartLoading = true;
      return this.$axios.get(this.$appConfig.routes.cart_quantity)
          .then(({ data }) => {
            this.cartQuantity = data;
            this.$nextTick(() => this.cartLoading = false);
          })
          .catch(error => {
            this.$toast.error('An error has occurred.');
            this.$nextTick(() => this.cartLoading = false);
          });
    }
  },
  mounted: function () {
    this.$root.$on('refresh-cart', this.refreshCart);
    this.refreshCart();
    console.log('ShopNav', this);
  }
}
</script>

<style lang="scss" scoped>
.shop-nav-link {
  color: $secondary;

  &:hover {
    color: $primary;
  }
}

.cart-quantity {
  position: absolute;
  top: 0;
  right: 0;
  width: 1.3125rem;
  height: 1.3125rem;
  line-height: 1.3125rem;
  font-size: 75%;
}

.cart-loader{
  width: 1.7rem;
  height: 1.7rem;
}
</style>