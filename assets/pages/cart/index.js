export default {
    data () {
        return {
            loader: null,
            cart: null
        }
    },
    created () {
        this.asyncData();
    },
    methods: {
        async asyncData () {
            this.loader = this.$loading.show();

            return await this.$axios.get(this.$appConfig.routes.cart_content)
                .then(({ data }) => {
                    this.cart = data;
                    this.$nextTick(this.loader.hide());
                })
                .catch(error => {
                    this.$toast.error('An error has occurred.');
                    this.$nextTick(this.loader.hide());
                });
        }
    }
}