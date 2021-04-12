export default {
    data () {
        return {
            user: null
        }
    },
    created () {
        this.loadUser();
    },
    methods: {
        async loadUser () {
            let loader = this.$loading.show();

            return await this.$axios.get(this.$appConfig.routes.account_user)
                .then(({ data }) => {
                    this.user = data;
                    this.$nextTick(loader.hide());
                })
                .catch(error => {
                    this.$toast.error('An error has occurred.');
                    this.$nextTick(loader.hide());
                });
        }
    }
}