import loaderMixin from '@/mixins/loader';
import { mapActions, mapGetters } from "vuex";

export default {
    mixins: [loaderMixin],
    data () {
        return {
            fields: [
                {
                    key: 'product',
                    label: 'Product',
                    class: ['col-6'],
                    thClass: ['border-0'],
                    formatter: this.productFormatter
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
    computed: {
        ...mapGetters({
            cart: 'cart/getCart'
        }),
        cartIsEmpty(){
            return !this.cart || !this.cart.items.length;
        }
    },
    created () {
        this.asyncData();
    },
    methods: {
        ...mapActions({
            refreshCart: 'cart/getTotalCount',
            getCart: 'cart/getCart',
        }),
        async asyncData () {
            if (this.isLoading) {
                return;
            }
            this.showLoader();

            await this.getContent();

            this.$nextTick(this.hideLoader);
        },
        getContent () {
            return this.getCart().catch(error => {
                this.$toast.error('An error has occurred.');
            });
        },
        async changeQuantity (id, quantity) {
            this.showLoader();

            await this.$axios.post(this.$appConfig.routes.cart_change_quantity, {
                id, quantity
            })
                .then(() => {
                    this.$toast.success('Quantity was successfully updated.');
                })
                .catch(error => {
                    this.$toast.error('An error has occurred.');
                });

            await this.getContent();

            this.$nextTick(this.hideLoader);
        },
        async remove (id) {
            this.showLoader();

            await this.$axios.post(this.$appConfig.routes.cart_remove, {
                id
            })
                .then(() => {
                    this.$toast.success('Item was successfully removed.');
                })
                .catch(error => {
                    this.$toast.error('An error has occurred.');
                });

            await this.getContent();

            await this.refreshCart();

            this.$nextTick(this.hideLoader);
        },
        productFormatter: (value) => {
            value.imageSrc = value.image ? `/media/${value.image}` : require('@/images/no-picture.svg');
            return value;
        }
    }
}