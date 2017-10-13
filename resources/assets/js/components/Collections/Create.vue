<script>
    import Form from './Form.vue';
    import { mapState } from 'vuex';
    import Errors from 'js/classes/Errors';

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
            submit() {
                this.$store.dispatch('createCollection', { collection: this.collection })
                    .then(response => {
                        this.$store.commit('addCollection', { collection: response.data });
                        this.$router.push({ path: `/users/${this.user.id}/collections` });
                    })
                    .catch(error => this.errors.record(error.response.data.errors));
            }
        }
    }
</script>
