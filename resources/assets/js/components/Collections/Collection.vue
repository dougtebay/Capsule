<template>
	<section class="collection">
		<div>{{ collection.title }}</div>
		<div>{{ collection.description }}</div>
		<router-link :to="{ name: 'collection', params: { id: collection.id }}">View</router-link>
	</section>
</template>

<script>
	export default {
		props: ['collection']
	}
</script>
