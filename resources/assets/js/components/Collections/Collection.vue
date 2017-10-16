<template>
    <section class="card" :id="collection.id">
        <div class="card-title">{{ collection.title }}</div>
        <div class="card-description">{{ collection.description }}</div>
        <section class="card-link-container">
            <router-link class="card-link"
                         :to="{ path: `/users/${user.id}/collections/${collection.id}`,
                                params: { collectionId: collection.id } }">View
            </router-link>
            <router-link class="card-link"
                         :to="{ path: `/users/${user.id}/collections/${collection.id}/edit`,
                                params: { collectionId: collection.id } }">Edit
            </router-link>
            <a class="card-link"href="" @click.prevent="deleteCollection({ collection })">Delete</a>
        </section>
    </section>
</template>

<script>
    import { mapState, mapActions } from 'vuex';

    export default {
        props: ['collection'],

        computed: {
            ...mapState(['user'])
        },

        methods: {
            ...mapActions(['deleteCollection'])
        }
    }
</script>
