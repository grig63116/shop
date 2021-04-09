<template>
  <b-card
      v-if="product"
      tag="article"
      align="center"
      :title="product.name"
      :img-src="image"
      :img-alt="product.name"
      img-top
  >
    <b-card-sub-title>
      <small><strong>Number:</strong> <span>{{ product.number }}</span></small>
    </b-card-sub-title>
    <b-card-text>
      <p>{{ product.description|truncate(50) }}</p>
      <p>{{ product.price|currency }}</p>
    </b-card-text>
    <b-button variant="primary" @click.stop.prevent="addToCart">Add to cart</b-button>
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
    addToCart () {

    }
  }
}
</script>

<style lang="scss" scoped>

</style>