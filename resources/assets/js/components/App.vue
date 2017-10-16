<template>
    <div>
        <navbar :appName="app_name" @logout="logout"></navbar>
        <main>
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
    import Navbar from './Navbar/Navbar.vue';
    import { mapState, mapActions } from 'vuex';

    export default {
        props: ['app_name', 'user_json', 'request_uri'],

        components: { Navbar },

        computed: {
            ...mapState(['user'])
        },

        methods: {
            ...mapActions(['getCollections']),

            logout() {
                axios.post('/logout').then(() => location.replace('/'));
            }
        },

        mounted() {
            if (this.user_json) {
                this.$store.commit('setUser', { user: JSON.parse(this.user_json) });
                this.getCollections();
            }

            if (this.request_uri) {
                this.$router.push({ path: this.request_uri });
            }
        }
    }
</script>
