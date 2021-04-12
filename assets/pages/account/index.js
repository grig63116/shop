import loaderMixin from '@/mixins/loader';

export default {
    mixins: [loaderMixin],
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
            this.showLoader();

            return await this.$axios.get(this.$appConfig.routes.account_user)
                .then(({ data }) => {
                    this.user = data;
                    this.$nextTick(this.hideLoader);
                })
                .catch(error => {
                    this.$toast.error('An error has occurred.');
                    this.$nextTick(this.hideLoader);
                });
        }
    }
}