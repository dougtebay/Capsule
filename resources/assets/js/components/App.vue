<template>
	<div>
		<navbar :appName="app_name"
				:user="user"
			    @search="doSearch"
			    @get-collections="getCollections"
			    @logout="logout">
		</navbar>
		<main>
			<search-results :query="search.query"
							:searchResults="search.results">
			</search-results>
			<collections :collections="collections">
			</collections>
		</main>
	</div>
</template>

<script>
	import Navbar from './Navbar.vue'
	import SearchResults from './SearchResults.vue'
	import Collections from './Collections.vue'

	export default {
		props: ['app_name', 'csrf_token', 'user_json'],

		components: {
			Navbar,
			SearchResults,
			Collections
		},

		data () {
			return {
				user: '',
				search: {
					query: '',
					results: []
				},
				collections: []
			}
		},

		methods: {
			doSearch (query) {
				this.search.query = query
                axios.get('/search', { params: {
                	query: query
                }
                }).then(function (response) {
                	this.search.results = response.data
                }.bind(this))
            },

			getCollections () {
                axios.get('/collections').then(function (response) {
                    this.collections = response.data
                }.bind(this))
            },

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
