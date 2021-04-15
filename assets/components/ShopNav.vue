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
      <div class="cart-total-count bg-primary text-white text-center text-nowrap font-weight-bold rounded-circle">
        {{ cartTotalCount }}
      </div>
    </b-nav-item>
  </b-nav>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters({
      cartTotalCount: 'cart/getTotalCount',
      cartLoading: 'cart/isLoading'
    })
  },
  methods: {
    ...mapActions({ refreshCart: 'cart/getTotalCount' })
  },
  created () {
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

.cart-total-count {
  position: absolute;
  top: 0;
  right: 0;
  width: 1.3125rem;
  height: 1.3125rem;
  line-height: 1.3125rem;
  font-size: 75%;
}

.cart-loader {
  width: 1.7rem;
  height: 1.7rem;
}
</style>