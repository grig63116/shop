export default {
    data () {
        return {
            user: null
        }
    },
    created () {
        this.asyncData();
    },
    methods: {
        async asyncData () {
            let loader = this.$loading.show();

            return await this.$axios.get(this.$appConfig.routes.account_user)
                .then(({ data }) => {
                    this.user = data;
                    this.$nextTick(loader.hide());
                })
                .catch(error => {
                    this.$nextTick(loader.hide());
                });
        }
    }
}