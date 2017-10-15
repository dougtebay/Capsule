<template>
    <section>
        <span v-if="errors.has('query')">No results</span>
        <search-result v-for="(searchResult, index) in searchResults"
                :id="index + 1"
                :searchResult="searchResult">
        </search-result>
    </section>
</template>

<script>
    import Errors from 'js/classes/Errors';
    import Helpers from 'js/mixins/Helpers.vue';
    import SearchResult from './SearchResult.vue';
    import { mapState, mapGetters, mapMutations } from 'vuex';

    export default {
        components: { SearchResult },

        mixins: [Helpers],

        data() {
            return {
                query: '',
                errors: new Errors()
            }
        },

        computed: {
            ...mapState(['user', 'searchResults']),

            ...mapGetters(['hasSearchResults']),

            cursor() {
                if (!this.hasSearchResults) {
                    return '-1';
                }

                return this.lastItem(this.searchResults).id_str;
            }
        },

        watch: {
            $route() {
                this.query = this.$route.query.query;
                this.clearSearchResults();
                this.getSearchResults();
            },
        },

        methods: {
            ...mapMutations(['clearSearchResults']),

            getSearchResults() {
                this.$store.dispatch('getSearchResults', { query: this.query, cursor: this.cursor })
                    .then(() => scrollTo(0, 0))
                    .catch(error => this.errors.record(error.response.data.errors));
            },

            setOnScrollEvent() {
                window.onscroll = () => {
                    if (this.hasRequestedMoreSearchResults()) {
                        this.getSearchResults();
                    }
                }
            },

            hasRequestedMoreSearchResults() {
                return this.hasSearchResults
                    && window.innerHeight + window.scrollY >= document.body.offsetHeight;
            }
        },

        created() {
            this.query = this.$route.query.query;
            this.getSearchResults();
            this.setOnScrollEvent();
        }
    }
</script>
