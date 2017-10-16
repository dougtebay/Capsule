<template>
    <section v-if="collection">
        <section class="card">
            <div>{{ collection.title }}</div>
            <div>{{ collection.description }}</div>
        </section>
        <section v-for="tweet in collection.tweets" v-if="collection.tweets">
            <tweet :collection="collection" :tweet="tweet"></tweet>
        </section>
    </section>
</template>

<script>
    import Tweet from './Tweet.vue';
    import { mapState, mapGetters, mapActions } from 'vuex';

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
            ...mapActions(['getTweets'])
        },

        created() {
            this.getTweets({ collectionId: this.collectionId });
        }
    }
</script>
