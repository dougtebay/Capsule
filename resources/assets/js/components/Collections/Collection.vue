<template>
	<section class="card">
		<div>{{ collection.title }}</div>
		<div>{{ collection.description }}</div>
		<router-link :to="{ path: `/users/${userId}/collections/${collection.id}`, params: { collectionId: collection.id }}">View
		</router-link>
		<router-link :to="{ path: `/users/${userId}/collections/${collection.id}/edit`, params: { collectionId: collection.id }}">Edit
		</router-link>
		<a href="" @click.prevent="destroy">Delete</a>
	</section>
</template>

<script>
	export default {
		props: ['userId', 'collection'],

		methods: {
			destroy() {
				axios.delete(`/api/users/${this.userId}/collections/${this.collection.id}`).then(function () {
					this.$emit('destroy', this.collection.id)
				}.bind(this))
			}
		}
	}
</script>
