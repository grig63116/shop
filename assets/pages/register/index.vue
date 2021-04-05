<template>
  <Page>
    <section class="login">
      <div class="text-center mb-4">
        <h4 class="mt-0 font-weight-bold">Sign Up</h4>
        <p class="text-muted mb-0">Don't have an account yet? Sign up now, it takes less than a minute.</p>
      </div>


      <b-row class="mt-3">
        <b-col cols="12" class="text-center">
          <p class="text-muted">
            Already have an account?
            <a :href="$appConfig.routes.login" class="text-muted ml-1"><b>Sign In</b></a>
          </p>
        </b-col>
      </b-row>
    </section>
  </Page>
</template>
<script src="./index.js"></script>
<style src="./index.scss" lang="scss" scoped></style>