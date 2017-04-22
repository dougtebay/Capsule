<template>
	<form>
		<input type="text" v-model="formData.title"></input>
		<input type="textarea" v-model="formData.description"></input>
		<input type="checkbox" v-model="formData.public"></input>
		<button @click.prevent="submit(formData)">Submit</button>
	</form>
</template>

<script>
	export default {
		data() {
			return {
				formData: {
					title: '',
					description: '',
					public: true
				}
			}
		},

		methods: {
			submit(collection) {
				axios.post('/api/collections', {
                	collection: collection
                }).then(function (response) {
                	//
                })
			}
		}
	}
</script>
