<script>
    import Form from './Form.vue';
    import Errors from 'js/classes/Errors';

    export default {
        extends: Form,

        props: ['userId', 'collectionId'],

        data() {
            return {
                collection: {},
                errors: new Errors()
            }
        },

        methods: {
            getCollection() {
                axios.get(`/api/users/${this.userId}/collections/${this.collectionId}`)
                    .then(response => this.collection = response.data);
            },

            submit() {
                axios({
                    method: 'put',
                    url: `/api/users/${this.userId}/collections/${this.collectionId}`,
                    data: this.collection
                })
                    .then(() => {
                        this.$router.push({
                            path: `/users/${this.userId}/collections/${this.collectionId}`
                        })
                    })
                    .catch(error => this.errors.record(error.response.data.errors));
            }
        },

        created() {
            this.getCollection();
        }
    }
</script>
