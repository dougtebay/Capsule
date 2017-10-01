<template>
    <section class="card" :id="tweet.id">
        <div>@{{ tweet.user_nickname }}</div>
        <div class="tweet-text">{{ tweet.text }}</div>
        <a href="" @click.prevent="destroy">Delete</a>
    </section>
</template>

<script>
    export default {
        props: ['collection', 'tweet'],

        methods: {
            destroy() {
                axios.delete(`/api/collections/${this.collection.id}/tweets/${this.tweet.id}`)
                    .then(() => this.$emit('destroy', this.tweet.id));
            }
        }
    }
</script>
