<script>
    import Form from './Form.vue';
    import Errors from 'js/classes/Errors';
    import { mapState, mapActions } from 'vuex';

    export default {
        extends: Form,

        data() {
            return {
                collection: {
                    title: '',
                    description: '',
                    public: 1
                },
                errors: new Errors()
            }
        },

        computed: {
            ...mapState(['user'])
        },

        methods: {
            ...mapActions(['createCollection']),

            submit() {
                this.createCollection({ collection: this.collection })
                    .then(() => this.$router.push({ path: `/users/${this.user.id}/collections` }))
                    .catch(error => this.errors.record(error.response.data.errors));
            }
        }
    }
</script>
