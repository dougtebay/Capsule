
<script>
    import Form from './Form.vue'
    import Errors from '../../classes/Errors.js'

    export default {
        extends: Form,

        props: ['userId'],

        data () {
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
            submit () {
                axios.post(`/api/users/${this.userId}/collections`, this.collection).then(function (response) {
                    this.$router.push({ path: `/users/${this.userId}/collections` })
                }.bind(this)).catch(error => this.errors.record(error.response.data.errors))
            }
        }
    }
</script>
