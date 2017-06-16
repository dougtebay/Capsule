
<script>
	import Form from './Form.vue'
	import { Errors } from '../../classes/Errors.js'

	export default {
		extends: Form,

		data () {
			return {
				collection: {
					title: '',
					description: '',
					public: true
				},
				errors: new Errors()
			}
		},

		methods: {
			submit (collection) {
				axios.post('/api/collections', this.collection).then(function (response) {
                	this.$router.push({ path: '/collections' })
                }.bind(this)).catch(error => this.errors.record(error.response.data))
			}
		}
	}
</script>
