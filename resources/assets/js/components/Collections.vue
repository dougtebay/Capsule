<template>
	<section class="collections">
		<collection v-for="collection in collections" :collection="collection"></collection>
	</section>
</template>

<script>
	import Collection from './Collection.vue'

	export default {
		props: ['collections'],

		components: {
			Collection
		}
	}
</script>
