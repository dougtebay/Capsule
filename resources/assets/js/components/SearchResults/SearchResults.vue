<template>
    <section>
        <search-result v-for="result in results" :result="result"></search-result>
        <button v-if="hasResults" @click="getMoreResults">More</button>
    </section>
</template>

<script>
    import SearchResult from './SearchResult.vue'
    import Helpers from './../../mixins/Helpers.vue'

    export default {
        components: {
            SearchResult
        },

        mixins: [Helpers],

        data () {
            return {
                query: '',
                results: []
            }
        },

        computed: {
            maxId: function () {
                if (this.results.length) {
                    return this.lastItem(this.results).twitter_tweet_id
                }

                return ''
            },

            hasResults: function () {
                return !!this.results.length
            }
        },

        watch: {
            $route: function () {
                this.getSearchResults()
            },
        },

        methods: {
            getSearchResults () {
                this.query = this.$route.query.query
                axios.get('/search', { params: {
                    query: this.query
                }
                }).then(function (response) {
                    scrollTo(0, 0)
                    this.results = response.data
                }.bind(this))
            },

            getMoreResults () {
                axios.get('/search', { params: {
                        query: this.query,
                        max_id: this.maxId
                    }
                }).then(function (response) {
                    this.setNewResults(response.data)
                }.bind(this))
            },

            setNewResults (results) {
                var newResults = results.splice(1);
                this.results = this.results.concat(newResults)
            }
        },

        created () {
            this.getSearchResults()
        }
    }
</script>
