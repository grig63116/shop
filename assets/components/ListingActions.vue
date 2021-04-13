<template>
  <b-row align-content="between" align-v="center" :no-gutters="true">
    <b-col>
      <paginate
          v-model="page"
          :page-count="pages"
          :page-range="pageRange"
          :margin-pages="marginPages"
          :no-li-surround="true"
          :first-last-button="true"
          page-link-class="btn btn-outline-secondary btn-sm mx-1"
          prev-link-class="btn btn-outline-secondary btn-sm mx-auto"
          next-link-class="btn btn-outline-secondary btn-sm mx-auto"
          break-view-link-class="border-0"
      >
      </paginate>
    </b-col>
    <b-col>
      <b-form-group
          class="justify-content-end align-items-center mb-0"
          label="Products per page"
          content-cols="auto"
          label-cols="auto"
          label-align="right"
          label-size="sm"
          :label-for="`per-page-${this._uid}`"
      >
        <b-form-select
            :id="`per-page-${this._uid}`"
            :options="perPageOptions"
            v-model="perPage"
            size="sm"
        ></b-form-select>
      </b-form-group>
    </b-col>
  </b-row>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data () {
    return {
      marginPages: 1,
      pageRange: 5,
      perPageOptions: [
        { value: 3, text: '3' },
        { value: 6, text: '6' },
        { value: 9, text: '9' },
        { value: 12, text: '12' },
        { value: 15, text: '15' },
        { value: 18, text: '18' },
        { value: 21, text: '21' },
        { value: 24, text: '24' },
        { value: 27, text: '27' }
      ]
    }
  },
  computed: {
    page: {
      get () {
        return this.$store.getters['listing/getPage'];
      },
      set (page) {
        this.$store.commit('listing/SET_PAGE', page);
      }
    },
    perPage: {
      get () {
        return this.$store.getters['listing/getPerPage'];
      },
      set (perPage) {
        this.$store.commit('listing/SET_PER_PAGE', perPage);
      }
    },
    ...mapGetters({
      total: 'listing/getTotal'
    }),
    pages () {
      return Math.ceil(this.total / this.perPage);
    }
  }
}
</script>

<style lang="scss" scoped>
.pagination-trigger {
  font-size: 0.625rem !important;
}

.pagination-separator {
  border: none;
}
</style>