<template>
	<section class="card">
		<div>@{{ tweet.user_nickname }}</div>
		<div>{{ tweet.text }}</div>
		<a href="" @click.prevent="destroy">Delete</a>
	</section>
</template>

<script>
	export default {
		props: ['collection', 'tweet'],

		methods: {
			destroy() {
				axios.delete(`/api/collections/${this.collection.id}/tweets/${this.tweet.id}`).then(function () {
					this.$emit('destroy', this.tweet.id)
				}.bind(this))
			}
		}
	}
</script>
