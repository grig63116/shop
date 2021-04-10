<template>
  <Page>
    <b-alert variant="warning" :show="!this.loader || (!this.loader.isActive && !this.cart)">
      You have no items in your shopping cart!
    </b-alert>
  </Page>
</template>
<script src="./index.js"></script>
<style src="./index.scss" lang="scss" scoped></style>