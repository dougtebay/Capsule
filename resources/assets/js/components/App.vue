<template>
	<div>
		<navbar :appName="app_name" :user="user"
				@search="doSearch" @get-collections="getCollections" @logout="logout">
		</navbar>
		<main>
			<search-results v-show="visible.searchResults"
							:query="search.query" :searchResults="search.results">
			</search-results>
			<collections v-show="visible.collections" :collections="collections"></collections>
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
				collections: [],
				visible: {
					searchResults: false,
					collections: false
				}
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
                	scrollTo(0, 0)
                	this.setVisible('searchResults')
                }.bind(this))
            },

			getCollections () {
                axios.get('/collections').then(function (response) {
                    this.collections = response.data
                    this.setVisible('collections')
                }.bind(this))
            },

            logout () {
                axios.post('/logout', {
                	_token: this.csrfToken
                }).then(function (response) {
                	location.replace('/')
                })
            },

            setVisible(component) {
            	for (let key in this.visible) {
            		key === component ? this.visible[key] = true : this.visible[key] = false
            	}
            }
		},

		mounted () {
			if (this.user_json) {
				this.user = JSON.parse(this.user_json)
			}
		}
	}
</script>
