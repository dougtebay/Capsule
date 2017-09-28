<template>
    <div>
        <navbar :appName="app_name" :user="user" @logout="logout"></navbar>
        <main>
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
    import axios from 'axios';
    import Navbar from './Navbar/Navbar.vue';

    export default {
        props: ['app_name', 'user_json', 'request_uri'],

        components: { Navbar },

        data() {
            return {
                user: ''
            }
        },

        methods: {
            logout() {
                axios.post('/logout')
                    .then(() => location.replace('/'));
            }
        },

        mounted() {
            if (this.user_json) {
                this.user = JSON.parse(this.user_json);
            }

            if (this.request_uri) {
                this.$router.push({ path: this.request_uri });
            }
        }
    }
</script>
