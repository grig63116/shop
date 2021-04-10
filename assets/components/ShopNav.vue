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
      <b-icon-cart3 font-scale="1.7"></b-icon-cart3>
      <div class="cart-count bg-primary text-white text-center text-nowrap font-weight-bold rounded-circle">
        {{ cartCount }}
      </div>
    </b-nav-item>
  </b-nav>
</template>

<script>
export default {
  data () {
    return {
      cartCount: 0,
    }
  },
  methods: {
    refreshCart () {
      let loader = this.$loading.show();

      return this.$axios.get(this.$appConfig.routes.cart_count)
          .then(({ data }) => {
            this.cartCount = data;
            this.$nextTick(loader.hide);
          })
          .catch(error => {
            this.$toast.error('An error has occurred.');
            this.$nextTick(loader.hide);
          });
    }
  },
  mounted: function () {
    this.$root.$on('refresh-cart', this.refreshCart);
    this.refreshCart();
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

.cart-count {
  position: absolute;
  top: 0;
  right: 0;
  width: 21px;
  height: 21px;
  line-height: 21px;
  font-size: 75%;
}
</style>