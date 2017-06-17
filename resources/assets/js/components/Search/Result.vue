<template>
	<section class="card">
		<div>@{{ result.user.screen_name }}</div>
		<div>{{ result.text }}</div>
		<form>
			<select v-model="selected">
				<option v-for="collection in collections" :value="collection.id">{{ collection.title }}</option>
			</select>
			<button @click.prevent="saveTweet(selected, result)">Save</button>
		</form>
	</section>
</template>

<script>
	export default {
		props: ['result', 'collections'],

		data() {
			return {
				selected: ''
			}
		},

		methods: {
			saveTweet(collectionId, tweet) {
				axios.post(`/api/collections/${collectionId}/tweets`, tweet).then(function (response) {
                	//
                }).catch(function (error) {
   					//
  				});
			}
		}
	}
</script>
