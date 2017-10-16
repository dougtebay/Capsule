<template>
    <section class="card" :id="tweet.id">
        <div>@{{ tweet.user_nickname }}</div>
        <div class="tweet-text">{{ tweet.text }}</div>
        <a href="" @click.prevent="deleteTweet({ collection, tweet })">Delete</a>
    </section>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        props: ['collection', 'tweet'],

        methods: {
            ...mapActions(['deleteTweet'])
        }
    }
</script>
