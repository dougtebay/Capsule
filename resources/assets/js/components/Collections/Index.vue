<template>
    <section>
        <collection v-for="collection in collections"
                    :userId="user.id"
                    :collection="collection">
        </collection>
    </section>
</template>

<script>
    import { mapState } from 'vuex';
    import Collection from './Collection.vue';

    export default {
        components: { Collection },

        computed: {
            ...mapState(['user', 'collections'])
        }
    }
</script>
