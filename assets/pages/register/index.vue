<template>
  <Page>
    <section class="login">
      <div class="text-center mb-4">
        <h4 class="mt-0 font-weight-bold">Sign Up</h4>
        <p class="text-muted mb-0">Don't have an account yet? Sign up now, it takes less than a minute.</p>
      </div>

      <template v-if="form">
        <b-form :id="form.id"
                ref="form"
                :name="form.full_name"
                :method="form.method"
                :action="form.action"
                @submit.stop.prevent="register">

          <b-form-group
              :id="form.children.email.id+`_fieldset`"
              :description="form.children.email.help"
              label="Email"
              :label-for="form.children.email.id"
              :state="form.children.email.valid?null:false"
          >
            <b-form-input
                :id="form.children.email.id"
                :name="form.children.email.full_name"
                :type="form.children.email.block_prefixes[2]"
                :value="form.children.email.value"
                :state="form.children.email.valid?null:false"
                :required="form.children.email.required"
                :aria-required="form.children.email.required"
                placeholder="Enter email"
                trim></b-form-input>
            <b-form-invalid-feedback v-for="error in form.children.email.errors" :key="error.message">
              {{ error.message }}
            </b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
              :id="form.children.plainPassword.children.first.id+`_fieldset`"
              :description="form.children.plainPassword.children.first.help"
              label="Password"
              :label-for="form.children.plainPassword.children.first.id"
              :state="form.children.plainPassword.children.first.valid?null:false"
          >
            <b-form-input
                :id="form.children.plainPassword.children.first.id"
                :name="form.children.plainPassword.children.first.full_name"
                :type="form.children.plainPassword.children.first.block_prefixes[2]"
                :value="form.children.plainPassword.children.first.value"
                :state="form.children.plainPassword.children.first.valid?null:false"
                :required="form.children.plainPassword.children.first.required"
                :aria-required="form.children.plainPassword.children.first.required"
                placeholder="Enter password"
                trim></b-form-input>
            <b-form-invalid-feedback v-for="error in form.children.plainPassword.children.first.errors"
                                     :key="error.message">
              {{ error.message }}
            </b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
              :id="form.children.plainPassword.children.second.id+`_fieldset`"
              :description="form.children.plainPassword.children.second.help"
              label="Repeat password"
              :label-for="form.children.plainPassword.children.second.id"
              :state="form.children.plainPassword.children.second.valid?null:false"
          >
            <b-form-input
                :id="form.children.plainPassword.children.second.id"
                :name="form.children.plainPassword.children.second.full_name"
                :type="form.children.plainPassword.children.second.block_prefixes[2]"
                :value="form.children.plainPassword.children.second.value"
                :state="form.children.plainPassword.valid?null:false"
                :required="form.children.plainPassword.children.second.required"
                :aria-required="form.children.plainPassword.children.second.required"
                placeholder="Enter password again"
                trim></b-form-input>
          </b-form-group>

          <b-form-group
              :id="form.children.firstName.id+`_fieldset`"
              :description="form.children.firstName.help"
              label="First name"
              :label-for="form.children.firstName.id"
              :state="form.children.firstName.valid?null:false"
          >
            <b-form-input
                :id="form.children.firstName.id"
                :name="form.children.firstName.full_name"
                :type="form.children.firstName.block_prefixes[1]"
                :value="form.children.firstName.value"
                :state="form.children.firstName.valid?null:false"
                :required="form.children.firstName.required"
                :aria-required="form.children.firstName.required"
                placeholder="Enter first name"
                trim></b-form-input>
            <b-form-invalid-feedback v-for="error in form.children.firstName.errors" :key="error.message">
              {{ error.message }}
            </b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
              :id="form.children.lastName.id+`_fieldset`"
              :description="form.children.lastName.help"
              label="Last name"
              :label-for="form.children.lastName.id"
              :state="form.children.lastName.valid?null:false"
          >
            <b-form-input
                :id="form.children.lastName.id"
                :name="form.children.lastName.full_name"
                :type="form.children.lastName.block_prefixes[1]"
                :value="form.children.lastName.value"
                :state="form.children.lastName.valid?null:false"
                :required="form.children.lastName.required"
                :aria-required="form.children.lastName.required"
                placeholder="Enter last name"
                trim></b-form-input>
            <b-form-invalid-feedback v-for="error in form.children.lastName.errors" :key="error.message">
              {{ error.message }}
            </b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
              :id="form.children.city.id+`_fieldset`"
              :description="form.children.city.help"
              label="City"
              :label-for="form.children.city.id"
              :state="form.children.city.valid?null:false"
          >
            <b-form-input
                :id="form.children.city.id"
                :name="form.children.city.full_name"
                :type="form.children.city.block_prefixes[1]"
                :value="form.children.city.value"
                :state="form.children.city.valid?null:false"
                :required="form.children.city.required"
                :aria-required="form.children.city.required"
                placeholder="Enter city"
                trim></b-form-input>
            <b-form-invalid-feedback v-for="error in form.children.city.errors" :key="error.message">
              {{ error.message }}
            </b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
              :id="form.children.street.id+`_fieldset`"
              :description="form.children.street.help"
              label="Street"
              :label-for="form.children.street.id"
              :state="form.children.street.valid?null:false"
          >
            <b-form-input
                :id="form.children.street.id"
                :name="form.children.street.full_name"
                :type="form.children.street.block_prefixes[1]"
                :value="form.children.street.value"
                :state="form.children.street.valid?null:false"
                :required="form.children.street.required"
                :aria-required="form.children.street.required"
                placeholder="Enter street"
                trim></b-form-input>
            <b-form-invalid-feedback v-for="error in form.children.street.errors" :key="error.message">
              {{ error.message }}
            </b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
              :id="form.children.zip.id+`_fieldset`"
              :description="form.children.zip.help"
              label="Zip"
              :label-for="form.children.zip.id"
              :state="form.children.zip.valid?null:false"
          >
            <b-form-input
                :id="form.children.zip.id"
                :name="form.children.zip.full_name"
                :type="form.children.zip.block_prefixes[1]"
                :value="form.children.zip.value"
                :state="form.children.zip.valid?null:false"
                :required="form.children.zip.required"
                :aria-required="form.children.zip.required"
                placeholder="Enter zip"
                trim></b-form-input>
            <b-form-invalid-feedback v-for="error in form.children.zip.errors" :key="error.message">
              {{ error.message }}
            </b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
              :id="form.children.phone.id+`_fieldset`"
              :description="form.children.phone.help"
              label="Phone"
              :label-for="form.children.phone.id"
              :state="form.children.phone.valid?null:false"
          >
            <b-form-input
                :id="form.children.phone.id"
                :name="form.children.phone.full_name"
                :type="form.children.phone.block_prefixes[1]"
                :value="form.children.phone.value"
                :state="form.children.phone.valid?null:false"
                :required="form.children.phone.required"
                :aria-required="form.children.phone.required"
                placeholder="Enter phone"
                trim></b-form-input>
            <b-form-invalid-feedback v-for="error in form.children.phone.errors" :key="error.message">
              {{ error.message }}
            </b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
              :id="form.children.termsAccepted.id+`_fieldset`"
              :description="form.children.termsAccepted.help"
              :label-for="form.children.termsAccepted.id"
              :state="form.children.termsAccepted.valid?null:false"
          >
            <b-form-checkbox
                :id="form.children.termsAccepted.id"
                :name="form.children.termsAccepted.full_name"
                :value="form.children.termsAccepted.value"
                :state="form.children.termsAccepted.valid?null:false"
            >
              I accept the terms and use
            </b-form-checkbox>
          </b-form-group>


          <input :id="form.children._token.id"
                 :name="form.children._token.full_name"
                 :value="form.children._token.value"
                 :data-value="$appConfig.csrf_token"
                 type="hidden"/>

          <b-form-invalid-feedback v-for="error in form.errors" :key="error.message">
            {{ error.message }}
          </b-form-invalid-feedback>

          <b-button
              class="mt-3"
              :id="form.children.submit.id"
              :name="form.children.submit.full_name"
              block
              type="submit"
              variant="primary">
            Sign up
          </b-button>
        </b-form>
      </template>

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