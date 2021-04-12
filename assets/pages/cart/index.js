export default {
    data () {
        return {
            loader: null,
            cart: null,
            fields: [
                {
                    key: 'product',
                    label: 'Product',
                    class: ['col-6'],
                    thClass: ['border-0']
                },
                {
                    key: 'quantity',
                    label: 'Quantity',
                    class: ['col-2', 'text-center', 'text-nowrap'],
                    thClass: ['border-0']
                },
                {
                    key: 'price',
                    label: 'Price per unit',
                    class: ['col-2', 'text-right', 'text-nowrap'],
                    thClass: ['border-0']
                },
                {
                    key: 'total',
                    label: 'Total price',
                    class: ['col-2', 'text-right', 'text-nowrap'],
                    thClass: ['border-0']
                },
                {
                    key: 'actions',
                    label: '',
                    class: ['text-right', 'text-nowrap'],
                    thClass: ['border-0']
                },
            ],
            quantityOptions: Array.from(Array(100).keys(), i => ++i)
        }
    },
    created () {
        console.log('Cart', this);
        this.asyncData();
    },
    methods: {
        async asyncData () {
            this.loader = this.$loading.show();

            return await this.$axios.get(this.$appConfig.routes.cart_content)
                .then(({ data }) => {
                    this.cart = data;
                    this.$nextTick(this.loader.hide);
                })
                .catch(error => {
                    this.$toast.error('An error has occurred.');
                    this.$nextTick(this.loader.hide);
                });
        },
        async changeQuantity (id) {
            await this.asyncData();
        },
        async remove (id) {
            await this.asyncData();
        }
    }
}