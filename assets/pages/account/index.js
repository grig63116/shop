export default {
    data () {
        return {
            user: {}
        }
    },
    created () {
        this.asyncData();
    },
    methods: {
        async asyncData () {
            let loader = this.$loading.show();

            return await this.$axios.get(this.$appConfig.routes.user)
                .then(({ data }) => {
                    this.user = data;
                    loader.hide();
                })
                .catch(error => {
                    loader.hide();
                });
        }
    }
}