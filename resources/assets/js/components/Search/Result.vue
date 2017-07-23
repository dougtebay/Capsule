<template>
	<section class="card">
		<div>@{{ result.user.screen_name }}</div>
		<div>{{ result.text }}</div>
		<form>
			<select name="collections" v-model="selected">
				<option v-for="collection in collections" :value="collection.id">{{ collection.title }}</option>
			</select>
			<button @click.prevent="saveTweet(selected, result)">Save</button>
			<div v-if="savedStatus" >{{ savedStatus }}</div>
		</form>
	</section>
</template>

<script>
	export default {
		props: ['result', 'collections'],

		data () {
			return {
				selected: '',
				savedStatus: ''
			}
		},

		methods: {
			saveTweet (collectionId, tweet) {
				axios.post(`/api/collections/${collectionId}/tweets`, tweet).then(function (response) {
					this.savedStatus = `Saved to ${this.collectionTitle(collectionId)}`
                }.bind(this))
			},

			collectionTitle (collectionId) {
				return this.collections.filter(collection => collection.id === collectionId)[0].title
			}
		}
	}
</script>
