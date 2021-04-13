export default {
    data () {
        return {
            loader: null
        }
    },
    computed: {
        isLoading () {
            return this.loader && this.loader.isActive;
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