<script>
    import Form from './Form.vue';
    import Errors from 'js/classes/Errors';
    import { mapState, mapGetters, mapActions } from 'vuex';

    export default {
        extends: Form,

        props: ['collectionId'],

        data() {
            return {
                form: {},
                errors: new Errors()
            }
        },

        computed: {
            ...mapState(['user', 'collections']),

            ...mapGetters(['getCollection']),

            collection() {
                return this.form = Object.assign({}, this.getCollection(this.collectionId));
            }
        },

        methods: {
            ...mapActions(['updateCollection']),

            submit() {
                this.updateCollection({ collection: this.form })
                    .then(() => {
                        this.$router.push({
                            path: `/users/${this.user.id}/collections/${this.collectionId}`
                        });
                    })
                    .catch(error => this.errors.record(error.response.data.errors));
            }
        }
    }
</script>
