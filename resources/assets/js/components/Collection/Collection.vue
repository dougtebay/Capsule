<template>
	<section>
		<section class="card">
			<div>{{ collection.title }}</div>
			<div>{{ collection.description }}</div>
		</section>
		<section v-for="tweet in collection.tweets">
			<tweet :tweet="tweet"></tweet>
		</section>
	</section>
</template>

<script>
	import Tweet from './Tweet.vue'

	export default {
		props: ['id'],

		components: {
			Tweet
		},

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
