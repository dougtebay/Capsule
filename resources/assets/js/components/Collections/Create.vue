
<script>
	import Form from './Form.vue'

	export default {
		extends: Form,

		data () {
			return {
				collection: {
					title: '',
					description: '',
					public: true
				}
			}
		},

		methods: {
			submit (collection) {
				axios.post('/api/collections', {
                	collection: collection
                }).then(function (response) {
                	//
                })
			}
		}
	}
</script>
