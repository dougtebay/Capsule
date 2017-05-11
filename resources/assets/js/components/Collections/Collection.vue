<template>
	<section class="card">
		<div>{{ collection.title }}</div>
		<div>{{ collection.description }}</div>
		<router-link :to="{ path: `/collections/${collection.id}`, params: { id: collection.id }}">View
		</router-link>
		<router-link :to="{ path: `/collections/${collection.id}/edit`, params: { id: collection.id }}">Edit
		</router-link>
		<a href="" @click.prevent="destroy">Delete</a>
	</section>
</template>

<script>
	export default {
		props: ['collection'],

		methods: {
			destroy() {
				axios.delete(`/api/collections/${this.collection.id}`).then(function () {
					this.$emit('destroy', this.collection.id)
				}.bind(this))
			}
		}
	}
</script>
