export default {
    data () {
        return {
            form: null,
            error: '',
            validation: null,
        }
    },
    created () {
        this.asyncData();
    },
    methods: {
        async asyncData () {
            let loader = this.$loading.show();

            return await this.$axios.get(this.$appConfig.routes.register_form)
                .then(({ data }) => {
                    console.log(data);
                    this.form = data;
                    this.$nextTick(loader.hide());
                })
                .catch(error => {
                    this.$nextTick(loader.hide());
                });
        },
        async register () {
            let loader = this.$loading.show();

            await this.$axios.post(this.$refs.form.action, this.getFormData())
                .then(response => {
                    window.location.href = this.$appConfig.routes.account;
                })
                .catch(({ response }) => {
                    console.log(response.data);
                    this.form = response.data;
                    this.$nextTick(loader.hide());
                });
        },
        getFormData () {
            return new URLSearchParams(new FormData(this.$refs.form)).toString();
        }
    }
}