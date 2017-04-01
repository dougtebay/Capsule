<template>
	<div>
		<navbar :appName="app_name"
			    :appUrl="app_url"
			    :csrfToken="csrf_token"
			    :user="user">
		</navbar>
	</div>
</template>

<script>
	import Navbar from './Navbar.vue';

	export default {
		props: ['app_name', 'app_url', 'csrf_token', 'user_json'],

		components: {
			Navbar
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
