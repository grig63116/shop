import loaderMixin from '@/mixins/loader';

export default {
    mixins: [loaderMixin],
    data () {
        return {
            form: null,
        }
    },
    created () {
        this.loadForm();
    },
    methods: {
        async loadForm () {
            this.showLoader();

            return await this.$axios.get(this.$appConfig.routes.register_form)
                .then(({ data }) => {
                    this.form = data;
                    this.$nextTick(this.hideLoader);
                })
                .catch(error => {
                    this.$toast.error('An error has occurred.');
                    this.$nextTick(this.hideLoader);
                });
        },
        async register () {
            this.showLoader();

            await this.$axios.post(this.$refs.form.action, new URLSearchParams(new FormData(this.$refs.form)).toString())
                .then(response => {
                    window.location.href = this.$appConfig.routes.account;
                })
                .catch(({ response }) => {
                    this.$toast.error('An error has occurred.');
                    this.form = response.data;
                    this.$nextTick(this.hideLoader);
                });
        }
    }
}