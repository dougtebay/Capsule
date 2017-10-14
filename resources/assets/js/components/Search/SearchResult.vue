<template>
    <section class="card">
        <div>@{{ searchResult.user.screen_name }}</div>
        <div>{{ searchResult.text }}</div>
        <form>
            <select name="collections" v-model="selected">
                <option v-for="collection in collections"
                        :value="collection.id">{{ collection.title }}
                </option>
            </select>
            <button @click.prevent="saveTweet(selected, searchResult)">Save</button>
            <div v-if="savedStatus" >{{ savedStatus }}</div>
        </form>
    </section>
</template>

<script>
    export default {
        props: ['searchResult', 'collections'],

        data () {
            return {
                selected: '',
                savedStatus: ''
            }
        },

        methods: {
            saveTweet(collectionId, tweet) {
                axios.post(`/api/collections/${collectionId}/tweets`, tweet)
                    .then(() => {
                        this.savedStatus = `Saved to ${this.collectionTitle(collectionId)}`;
                    });
            },

            collectionTitle(collectionId) {
                return this.collections.filter(collection => {
                    return collection.id === collectionId;
                })[0].title;
            }
        }
    }
</script>
