<template>
    <section class="card">
        <div>@{{ searchResult.user.screen_name }}</div>
        <div>{{ searchResult.text }}</div>
        <form>
            <select name="collections" v-model="collectionId">
                <option v-for="collection in collections"
                        :value="collection.id">{{ collection.title }}
                </option>
            </select>
            <button @click.prevent="saveTweet(collectionId, searchResult)">Save</button>
            <div v-if="savedStatus" >{{ savedStatus }}</div>
        </form>
    </section>
</template>

<script>
    import { mapState, mapGetters } from 'vuex';

    export default {
        props: ['searchResult'],

        data () {
            return {
                collectionId: '',
                savedStatus: ''
            }
        },

        computed: {
            ...mapState(['collections']),

            ...mapGetters(['getCollection'])
        },

        methods: {
            saveTweet() {
                this.$store.dispatch('addTweet', {
                    collectionId: this.collectionId, tweet: this.searchResult
                })
                    .then(() => {
                        this.savedStatus = `Saved to ${this.collectionTitle(this.collectionId)}`;
                    });
            },

            collectionTitle(collectionId) {
                return this.getCollection(collectionId).title;
            }
        }
    }
</script>
