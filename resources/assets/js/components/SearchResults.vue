<template>
    <div>
        <search-result v-for="result in results" :result="result"></search-result>
        <button v-if="hasResults" @click="getMoreResults">More</button>
    </div>
</template>

<script>
    import eventHub from './../app.js'
    import SearchResult from './SearchResult.vue'
    import Helpers from './../mixins/Helpers.vue'

    export default {
        components: {
            SearchResult
        },

        mixins: [Helpers],

        data() {
            return {
                query: '',
                results: []
            }
        },

        computed: {
            maxId: function() {
                if (this.results.length) {
                    return this.lastItem(this.results).twitter_tweet_id
                }

                return ''
            },

            hasResults: function() {
                return !!this.results.length
            }
        },

        methods: {
            getMoreResults() {
                axios.get('/search', { params: {
                        query: this.query,
                        max_id: this.maxId
                    }
                }).then(function (response) {
                    this.setNewResults(response.data)
                }.bind(this))
            },

            setNewResults(results) {
                var newResults = results.splice(1);
                this.results = this.results.concat(newResults)
            }
        },

        created() {
            eventHub.$on('results-found', response => {
                this.query = response.query
                this.results = response.results
            })
        }
    }
</script>
