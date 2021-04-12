export default {
    data () {
        return {
            loader: null
        }
    },
    methods: {
        showLoader () {
            this.loader = this.$loading.show();
        },
        hideLoader () {
            this.loader.hide();
        }
    }
}