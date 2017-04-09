<template>
	<section class="collection">
		<div>{{ collection.title }}</div>
		<div>{{ collection.description }}</div>
	</section>
</template>

<script>
	export default {
		props: ['id'],

		data() {
			return {
				collection: {}
			}
		},

		methods: {
			getCollection () {
                axios.get(`/collections/${this.id}`).then(function (response) {
                	this.collection = response.data
                }.bind(this))
			}
		},

		created() {
			this.getCollection()
		}
	}
</script>
