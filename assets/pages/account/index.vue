<template>
  <Page>
    <section class="account">
      <div class="text-center mb-4">
        <h4 class="mt-0 font-weight-bold">Welcome!</h4>
      </div>

       <b-row class="mt-2" align-v="center" align-h="center">
        <b-col class="text-right font-weight-bold">First name:</b-col>
        <b-col>{{ user.firstName }}</b-col>
      </b-row>

       <b-row class="mt-2" align-v="center" align-h="center">
        <b-col class="text-right font-weight-bold">Last name:</b-col>
        <b-col>{{ user.lastName }}</b-col>
      </b-row>

       <b-row class="mt-2" align-v="center" align-h="center">
        <b-col class="text-right font-weight-bold">Email:</b-col>
        <b-col>{{ user.email }}</b-col>
      </b-row>

       <b-row class="mt-2" align-v="center" align-h="center">
        <b-col class="text-right font-weight-bold">Phone:</b-col>
        <b-col>{{ user.phone }}</b-col>
      </b-row>

       <b-row class="mt-2" align-v="center" align-h="center">
        <b-col class="text-right font-weight-bold">Street:</b-col>
        <b-col>{{ user.street }}</b-col>
      </b-row>

       <b-row class="mt-2" align-v="center" align-h="center">
        <b-col class="text-right font-weight-bold">Zip:</b-col>
        <b-col>{{ user.zip }}</b-col>
      </b-row>

       <b-row class="mt-2" align-v="center" align-h="center">
        <b-col class="text-right font-weight-bold">City:</b-col>
        <b-col>{{ user.city }}</b-col>
      </b-row>

       <b-row class="mt-4" align-v="center" align-h="center">
        <b-link class="d-flex" :href="$appConfig.routes.logout">
          <b-icon-box-arrow-right class="mr-2" font-scale="1.5"></b-icon-box-arrow-right>
          Logout
        </b-link>
      </b-row>
    </section>
  </Page>
</template>
<script src="./index.js"></script>
<style src="./index.scss" lang="scss" scoped></style>