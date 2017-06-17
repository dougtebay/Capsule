<template>
    <section>
        <result v-for="result in results" :result="result" :collections="collections"></result>
        <button v-if="hasResults" @click="getMoreResults">More</button>
    </section>
</template>

<script>
    import Result from './Result.vue'
    import Helpers from '../../mixins/Helpers.vue'

    export default {
        components: { Result },

        mixins: [Helpers],

        data () {
            return {
                userId: '',
                query: '',
                results: [],
                collections: []
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
                this.getResults()
            },
        },

        methods: {
            getResults () {
                axios.get('/api/search', {
                    params: { query: this.query }
                }).then(function (response) {
                    scrollTo(0, 0)
                    this.results = response.data
                }.bind(this))
            },

            getCollections () {
                axios.get(`/api/users/${this.userId}/collections`).then(function (response) {
                    this.collections = response.data
                }.bind(this))
            },

            getMoreResults () {
                axios.get('/api/search', {
                    params: {
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
            this.userId = this.$route.query.userId
            this.query = this.$route.query.query
            this.getResults()
            this.getCollections()
        }
    }
</script>
