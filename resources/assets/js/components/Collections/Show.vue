<template>
    <section>
        <section class="card">
            <div>{{ collection.title }}</div>
            <div>{{ collection.description }}</div>
        </section>
        <section v-for="tweet in collection.tweets">
            <tweet :collection="collection" :tweet="tweet"></tweet>
        </section>
    </section>
</template>

<script>
    import Tweet from './Tweet.vue';
    import { mapState, mapGetters } from 'vuex';

    export default {
        props: ['collectionId'],

        components: { Tweet },

        computed: {
            ...mapState(['user']),

            ...mapGetters(['getCollection']),

            collection() {
                return this.getCollection(this.collectionId);
            }
        },

        methods: {
            getTweets() {
                this.$store.dispatch('getTweets', { collection: this.collection });
            }
        },

        created() {
            if (!this.collection.tweets) {
                this.getTweets();
            }
        }
    }
</script>
