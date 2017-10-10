<template>
    <div>
        <navbar :appName="app_name" @logout="logout"></navbar>
        <main>
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    import Navbar from './Navbar/Navbar.vue';

    export default {
        props: ['app_name', 'user_json', 'request_uri'],

        components: { Navbar },

        computed: {
            ...mapState(['user'])
        },

        methods: {
            logout() {
                axios.post('/logout').then(() => location.replace('/'));
            }
        },

        mounted() {
            if (this.user_json) {
                this.$store.commit('setUser', { user: JSON.parse(this.user_json) });
                this.$store.dispatch('getCollections').then(response => {
                    this.$store.commit('setCollections', { collections: response.data });
                });
            }

            if (this.request_uri) {
                this.$router.push({ path: this.request_uri });
            }
        }
    }
</script>
