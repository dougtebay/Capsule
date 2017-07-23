<template>
    <section>
        <result v-for="result in results" :result="result" :collections="collections"></result>
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
            maxId () {
                if (this.results.length) {
                    return this.lastItem(this.results).id_str
                }

                return ''
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
                        query: this.query
                    }
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

            setOnScrollEvent() {
                window.onscroll = event => {
                    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                        this.getMoreResults()
                    }
                }
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
            this.query = this.$route.query.query
            this.userId = this.$route.query.userId
            this.getResults()
            this.getCollections()
            this.setOnScrollEvent()
        }
    }
</script>
