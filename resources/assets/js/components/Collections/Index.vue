<template>
    <section>
        <collection v-for="collection in collections" :collection="collection"></collection>
    </section>
</template>

<script>
    import { mapState } from 'vuex';
    import Collection from './Collection.vue';

    export default {
        components: { Collection },

        computed: {
            ...mapState(['collections'])
        }
    }
</script>
