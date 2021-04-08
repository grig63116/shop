<template>
  <b-row>
    <b-col>
      <paginate
          v-model="page"
          :page-count="pagesCount"
          :page-range="pageRange"
          :margin-pages="marginPages"
          :click-handler="clickCallback"
          :no-li-surround="true"
          :first-last-button="true"
          page-link-class="btn btn-outline-primary btn-sm mx-1"
          prev-link-class="btn btn-outline-primary btn-sm mx-auto"
          next-link-class="btn btn-outline-primary btn-sm mx-auto"
      >
      </paginate>
    </b-col>
    <b-col>
      <label :for="`per-page-${this._uid}`">Products per page</label>
      <b-form-select
          :id="`per-page-${this._uid}`"
          :options="perPageOptions"
          v-model="perPage"
          size="sm"
      ></b-form-select>
    </b-col>
  </b-row>
</template>

<script>
export default {
  props: {
    currentPage: {
      type: Number,
      default: 1
    },
    pagesCount: {
      type: Number,
      default: 1
    },
    perPageCount: {
      type: Number,
      default: 9
    }
  },
  watch: {
    currentPage (page) {
      this.page = page;
    },
    perPageCount (perPage) {
      console.log('perPageCount',perPage);
      this.perPage = perPage;
    },
    perPage (perPage) {
      console.log('perPage',perPage);
      this.$emit('changePerPage', perPage);
    }
  },
  data () {
    return {
      pageRange: 5,
      marginPages: 1,
      page: 1,
      perPage: 9,
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
  methods: {
    clickCallback (page) {
      this.$emit('changePage', page);
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