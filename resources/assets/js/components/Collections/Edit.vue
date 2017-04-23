<script>
	import Form from './Form.vue'

	export default {
		extends: Form,

		props: ['id'],

		mixins: [''],

		data () {
			return {
				collection: {}
			}
		},

		methods: {
			getCollection () {
                axios.get(`/api/collections/${this.id}`).then(function (response) {
                	this.collection = response.data
                }.bind(this))
			},

			submit (collection) {
				axios.patch(`/api/collections/${this.id}`, {
                	collection: collection
                }).then(function (response) {
                	this.$router.push({ path: `/collections/${this.id}` })
                }.bind(this))
			}
		},

		created () {
			this.getCollection()
		}
	}
</script>
