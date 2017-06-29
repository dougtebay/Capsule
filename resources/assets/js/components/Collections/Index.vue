<template>
	<section>
		<collection v-for="collection in collections"
					:userId="userId"
					:collection="collection"
					@destroy="destroy">
		</collection>
	</section>
</template>

<script>
	import Collection from './Collection.vue'

	export default {
		components: { Collection },

		props: ['userId'],

		data () {
			return {
				collections: []
			}
		},

		methods: {
			getCollections () {
                axios.get(`/api/users/${this.userId}/collections`).then(function (response) {
                	this.collections = response.data
                }.bind(this))
			},

			destroy (collectionId) {
				this.collections.forEach((collection, index) => {
					if (collection.id === collectionId) {
						this.collections.splice(index, 1)
					}
				})
			}
		},

		created () {
			this.getCollections()
		}
	}
</script>
