<template>
	<section class="collection">
		<div>{{ collection.title }}</div>
		<div>{{ collection.description }}</div>
	</section>
</template>

<script>
	export default {
		props: ['collection']
	}
</script>
