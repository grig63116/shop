<template>
  <b-nav>
    <b-nav-item :href="$appConfig.routes.account">
      <b-icon-person font-scale="1.7"></b-icon-person>
    </b-nav-item>
    <b-nav-item :href="$appConfig.routes.cart">
      <b-icon-cart3 font-scale="1.4"></b-icon-cart3>
    </b-nav-item>
  </b-nav>
</template>