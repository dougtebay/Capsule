<template>
	<section class="card">
		<div>@{{ result.user_nickname }}</div>
		<div>{{ result.text }}</div>
		<form>
			<select v-model="selected">
				<option v-for="collection in collections" :value="collection.id">{{ collection.title }}</option>
			</select>
			<button @click.prevent="saveTweet(result, selected)">Save</button>
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
			saveTweet(tweet, collectionId) {
				axios.post('/tweets', {
                	tweet: tweet,
                	collectionId: collectionId
                }).then(function (response) {
                	//
                })
			}
		}
	}
</script>
