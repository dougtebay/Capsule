<template>
    <section class="card" :id="collection.id">
        <div class="card-title">{{ collection.title }}</div>
        <div class="card-description">{{ collection.description }}</div>
        <section class="card-link-container">
            <router-link class="card-link"
                         :to="{ path: `/users/${userId}/collections/${collection.id}`,
                                params: { collectionId: collection.id } }">View
            </router-link>
            <router-link class="card-link"
                         :to="{ path: `/users/${userId}/collections/${collection.id}/edit`,
                                params: { collectionId: collection.id } }">Edit
            </router-link>
            <a class="card-link" href="" @click.prevent="destroy">Delete</a>
        </section>
    </section>
</template>

<script>
    import axios from 'axios';

    export default {
        props: ['userId', 'collection'],

        methods: {
            destroy() {
                axios(`/api/users/${this.userId}/collections/${this.collection.id}`)
                    .then(() => this.$emit('destroy', this.collection.id));
            }
        }
    }
</script>
