<script>
	import Form from './Form.vue'
	import Errors from '../../classes/Errors.js'

	export default {
		extends: Form,

		props: ['userId', 'collectionId'],

		data () {
			return {
				collection: {},
				errors: new Errors()
			}
		},

		methods: {
			getCollection () {
                axios.get(`/api/users/${this.userId}/collections/${this.collectionId}`).then(function (response) {
                	this.collection = response.data
                }.bind(this))
			},

			submit () {
				axios.patch(`/api/users/${this.userId}/collections/${this.collectionId}`, this.collection).then(function (response) {
                	this.$router.push({ path: `/users/${this.userId}/collections/${this.collectionId}` })
                }.bind(this)).catch(error => this.errors.record(error.response.data))
			}
		},

		created () {
			this.getCollection()
		}
	}
</script>
