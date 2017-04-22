<template>
	<section>
		<collection v-for="collection in collections" :collection="collection"></collection>
	</section>
</template>

<script>
	import Collection from './Collection.vue'

	export default {
		props: ['user'],

		components: {
			Collection
		},

		data() {
			return {
				collections: []
			}
		},

		methods: {
			getCollections () {
                axios.get('/api/collections').then(function (response) {
                	this.collections = response.data
                }.bind(this))
			}
		},

		created() {
			this.getCollections()
		}
	}
</script>
