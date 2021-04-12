import loaderMixin from '@/mixins/loader';

export default {
    mixins: [loaderMixin],
    data () {
        return {
            error: '',
            validation: null,
        }
    },
    methods: {
        async login () {
            this.showLoader();

            await this.$axios.post(this.$refs.form.action, Object.fromEntries(new FormData(this.$refs.form)))
                .then(response => {
                    this.error = '';
                    this.validation = true;
                    window.location.href = this.$appConfig.routes.account;
                })
                .catch(({ response }) => {
                    this.error = response.data.error;
                    this.validation = false;
                    this.$toast.error('An error has occurred.');
                    this.$nextTick(this.hideLoader);
                });
        }
    }
}