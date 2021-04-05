export default {
    data () {
        return {
            error: '',
            validation: null,
        }
    },
    methods: {
        async submit (event) {
            event.preventDefault();

            let loader = this.$loading.show(),
                data = this.getFormData();

            await this.$axios.post(this.$refs.form.action, data)
                .then(response => {
                    this.error = '';
                    this.validation = true;
                    window.location.href = this.$appConfig.routes.account;
                })
                .catch(({ response }) => {
                    this.error = response.data.error;
                    this.validation = false;
                    loader.hide();
                });
        },
        getFormData () {
            let data = {},
                formData = new FormData(this.$refs.form);

            formData.forEach(function (value, key) {
                data[key] = value;
            });

            return data;
        }
    }
}