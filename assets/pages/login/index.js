export default {
    data () {
        return {
            error: '',
            validation: null,
        }
    },
    methods: {
        async login () {
            let loader = this.$loading.show();

            await this.$axios.post(this.$refs.form.action, this.getFormData())
                .then(response => {
                    this.error = '';
                    this.validation = true;
                    window.location.href = this.$appConfig.routes.account;
                })
                .catch(({ response }) => {
                    this.error = response.data.error;
                    this.validation = false;
                    this.$toast.error('An error has occurred.');
                    this.$nextTick(loader.hide());
                });
        },
        getFormData () {
            return Object.fromEntries(new FormData(this.$refs.form));
        }
    }
}