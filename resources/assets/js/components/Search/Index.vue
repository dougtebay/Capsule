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
    import axios from 'axios';
    import Result from './Result.vue';
    import Errors from '../../classes/Errors';
    import Helpers from '../../mixins/Helpers.vue';

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
            cursor() {
                if (!this.results.length) {
                    return '-1';
                }

                return this.lastItem(this.results).id_str;
            },

            hasResults() {
                return !!this.results.length;
            }
        },

        watch: {
            $route() {
                this.query = this.$route.query.query;
                this.getResults();
            },
        },

        methods: {
            getResults() {
                axios.get('/api/search', { params: { query: this.query, cursor: this.cursor } })
                    .then(response => {
                        scrollTo(0, 0);
                        this.results = response.data;
                        this.getCollections();
                    })
                    .catch(error => this.errors.record(error.response.data.errors));
            },

            getCollections() {
                axios.get(`/api/users/${this.userId}/collections`)
                    .then(response => this.collections = response.data);
            },

            setOnScrollEvent() {
                window.onscroll = () => {
                    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                        this.getMoreResults();
                    }
                }
            },

            getMoreResults() {
                axios.get('/api/search', { params: { query: this.query, cursor: this.cursor } })
                    .then(response => this.setMoreResults(response.data));
            },

            setMoreResults(results) {
                var moreResults = results.splice(1);
                this.results = this.results.concat(moreResults);
            }
        },

        created() {
            this.query = this.$route.query.query;
            this.userId = this.$route.query.userId;
            this.getResults();
            this.setOnScrollEvent();
        }
    }
</script>
