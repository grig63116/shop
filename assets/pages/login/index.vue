<template>
  <Page>
    <section class="login">
      <div class="text-center mb-4">
        <h4 class="mt-0 font-weight-bold">Sign In</h4>
        <p class="text-muted mb-0">Log in with email address and password</p>
      </div>

      <b-alert v-if="error" show variant="danger">{{ error }}</b-alert>

      <b-form method="post" :action="$appConfig.routes.login_handler" @submit.stop.prevent="login" ref="form">

        <b-input-group class="mb-2">
          <b-input-group-prepend is-text>
            <b-icon-envelope aria-hidden="true"></b-icon-envelope>
          </b-input-group-prepend>
          <b-form-input type="email"
                        name="email"
                        placeholder="Enter your email"
                        required
                        :state="validation"
                        aria-required="true"></b-form-input>
        </b-input-group>

        <b-input-group class="mb-2">
          <b-input-group-prepend is-text>
            <b-icon-lock aria-hidden="true"></b-icon-lock>
          </b-input-group-prepend>
          <b-form-input type="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                        :state="validation"
                        aria-required="true"></b-form-input>
        </b-input-group>

        <input type="hidden" name="_csrf_token"
               :value="$appConfig.csrf_token"/>

        <b-button block type="submit" variant="primary">Sign in</b-button>
      </b-form>

      <b-row class="mt-3">
        <b-col cols="12" class="text-center">
          <p class="text-muted">
            Don't have an account?
            <a :href="$appConfig.routes.register" class="text-muted ml-1"><b>Sign Up</b></a>
          </p>
        </b-col>
      </b-row>
    </section>
  </Page>
</template>
<script src="./index.js"></script>
<style src="./index.scss" lang="scss" scoped></style>