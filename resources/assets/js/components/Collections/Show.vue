<template>
	<section>
		<section class="card" v-if="hasCollection">
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

		computed: {
			hasCollection: function() {
				return !!Object.keys(this.collection).length
			}
		},

		methods: {
			getCollection () {
                axios.get(`/api/collections/${this.id}`).then(function (response) {
                	this.collection = response.data
                }.bind(this))
			}
		},

		created() {
			this.getCollection()
		}
	}
</script>
