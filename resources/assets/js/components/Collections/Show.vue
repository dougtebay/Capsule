<template>
    <section>
        <section class="card" v-if="hasCollection">
            <div>{{ collection.title }}</div>
            <div>{{ collection.description }}</div>
        </section>
        <section v-for="tweet in collection.tweets">
            <tweet :collection="collection" :tweet="tweet" @destroy="destroy"></tweet>
        </section>
    </section>
</template>

<script>
    import axios from 'axios';
    import Tweet from './Tweet.vue';

    export default {
        props: ['userId', 'collectionId'],

        components: { Tweet },

        data() {
            return {
                collection: {}
            }
        },

        computed: {
            hasCollection() {
                return !!Object.keys(this.collection).length;
            }
        },

        methods: {
            getCollection() {
                axios({
                    method: 'get',
                    url: `/api/users/${this.userId}/collections/${this.collectionId}`,
                    params: { 'with-tweets': true }
                })
                    .then(response => this.collection = response.data);
            },

            destroy(tweetId) {
                this.collection.tweets.forEach((tweet, index) => {
                    if (tweet.id === tweetId) {
                        this.collection.tweets.splice(index, 1);
                    }
                });
            }
        },

        created() {
            this.getCollection();
        }
    }
</script>
