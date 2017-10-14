<script>
    import Form from './Form.vue';
    import Errors from 'js/classes/Errors';
    import { mapState, mapGetters } from 'vuex';

    export default {
        extends: Form,

        props: ['collectionId'],

        data() {
            return {
                collection: {},
                errors: new Errors()
            }
        },

        computed: {
            ...mapState(['user']),

            ...mapGetters(['getCollection'])
        },

        methods: {
            submit() {
                this.$store.dispatch('updateCollection', { collection: this.collection })
                    .then(() => {
                        this.$router.push({
                            path: `/users/${this.user.id}/collections/${this.collectionId}`
                        });
                    })
                    .catch(error => this.errors.record(error.response.data.errors));
            }
        },

        created() {
            Object.assign(this.collection, this.getCollection(this.collectionId));
        }
    }
</script>
