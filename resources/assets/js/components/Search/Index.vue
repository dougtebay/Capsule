<template>
    <section>
        <span v-if="errors.has('query')">No results</span>
        <result v-for="(result, index) in results"
                :id="index + 1"
                :result="result"
                :collections="collections">
        </result>
    </section>
</template>

<script>
    import Result from './Result.vue'
    import Helpers from '../../mixins/Helpers.vue'
    import Errors from '../../classes/Errors'

    export default {
        components: { Result },

        mixins: [Helpers],

        data () {
            return {
                userId: '',
                query: '',
                results: [],
                collections: [],
                errors: new Errors()
            }
        },

        computed: {
            cursor () {
                if (this.results.length) {
                    return this.lastItem(this.results).id_str
                }

                return '-1';
            },

            hasResults () {
                return !!this.results.length
            }
        },

        watch: {
            $route () {
                this.getResults()
            },
        },

        methods: {
            getResults () {
                axios.get('/api/search', {
                    params: {
                        query: this.query,
                        cursor: this.cursor
                    }
                }).then(function (response) {
                    scrollTo(0, 0)
                    this.results = response.data
                }.bind(this)).catch(error => this.errors.record(error.response.data))
            },

            getCollections () {
                axios.get(`/api/users/${this.userId}/collections`).then(function (response) {
                    this.collections = response.data
                }.bind(this))
            },

            setOnScrollEvent () {
                window.onscroll = () => {
                    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                        this.getMoreResults()
                    }
                }
            },

            getMoreResults () {
                axios.get('/api/search', {
                    params: {
                        query: this.query,
                        cursor: this.cursor
                    }
                }).then(function (response) {
                    this.setMoreResults(response.data)
                }.bind(this))
            },

            setMoreResults (results) {
                var moreResults = results.splice(1);
                this.results = this.results.concat(moreResults)
            }
        },

        created () {
            this.query = this.$route.query.query
            this.userId = this.$route.query.userId
            this.getResults()
            this.getCollections()
            this.setOnScrollEvent()
        }
    }
</script>
