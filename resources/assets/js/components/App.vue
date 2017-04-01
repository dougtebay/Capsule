<template>
	<main>
		<navbar :appName="app_name"
			    :appUrl="app_url"
			    :csrfToken="csrf_token"
			    :user="user">
		</navbar>
		<search-results></search-results>
	</main>
</template>

<script>
	import Navbar from './Navbar.vue'
	import SearchResults from './SearchResults.vue'

	export default {
		props: ['app_name', 'app_url', 'csrf_token', 'user_json'],

		components: {
			Navbar,
			SearchResults
		},

		data() {
			return {
				user: ''
			}
		},

		mounted() {
			if (this.user_json) {
				this.user = JSON.parse(this.user_json)
			}
		}
	}
</script>
