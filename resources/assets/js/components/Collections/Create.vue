<script>
    import Form from './Form.vue';
    import Errors from 'js/classes/Errors';

    export default {
        extends: Form,

        props: ['userId'],

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

        methods: {
            submit() {
                this.$store.dispatch('createCollection', { collection: this.collection })
                    .then(response => {
                        this.$store.commit('addCollection', { collection: response.data });
                        this.$router.push({ path: `/users/${this.userId}/collections` });
                    })
                    .catch(error => this.errors.record(error.response.data.errors));
            }
        }
    }
</script>
