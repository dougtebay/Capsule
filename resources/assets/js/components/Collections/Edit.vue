<script>
	import Form from './Form.vue'
	import { Errors } from '../../classes/Errors.js'

	export default {
		extends: Form,

		props: ['id'],

		data () {
			return {
				collection: {},
				errors: new Errors()
			}
		},

		methods: {
			getCollection () {
                axios.get(`/api/collections/${this.id}`).then(function (response) {
                	this.collection = response.data
                }.bind(this))
			},

			submit () {
				axios.patch(`/api/collections/${this.id}`, this.collection).then(function (response) {
                	this.$router.push({ path: `/collections/${this.id}` })
                }.bind(this)).catch(error => this.errors.record(error.response.data))
			}
		},

		created () {
			this.getCollection()
		}
	}
</script>
