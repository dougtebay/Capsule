<template>
	<section class="card">
		<div>{{ collection.title }}</div>
		<div>{{ collection.description }}</div>
		<router-link :to="{ path: `/collections/${collection.id}`, params: { id: collection.id }}">View
		</router-link>
		<router-link :to="{ path: `/collections/${collection.id}/edit`, params: { id: collection.id }}">Edit
		</router-link>
	</section>
</template>

<script>
	export default {
		props: ['collection']
	}
</script>
