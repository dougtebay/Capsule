<template>
	<div>
		<navbar :appName="app_name" :user="user" @logout="logout"></navbar>
		<main>
			<router-view></router-view>
		</main>
	</div>
</template>

<script>
	import Navbar from './Navbar/Navbar.vue'

	export default {
		props: ['app_name', 'csrf_token', 'user_json'],

		components: {
			Navbar
		},

		data () {
			return {
				user: ''
			}
		},

		methods: {
            logout () {
                axios.post('/logout', {
                	_token: this.csrfToken
                }).then(function (response) {
                	location.replace('/')
                })
            }
		},

		mounted () {
			if (this.user_json) {
				this.user = JSON.parse(this.user_json)
			}
		}
	}
</script>
