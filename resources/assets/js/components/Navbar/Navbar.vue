<template>
    <div class="navbar-container">
        <nav class="navbar">
            <section>
                <a class="navbar-text" href="/">{{ appName }}</a>
            </section>
            <section v-if="isGuest">
                <a class="navbar-text" href="/login">Login</a>
            </section>
            <section v-else>
                <search-form></search-form>
                <span class="navbar-text">{{ user.name }}</span>
                <router-link class="navbar-text"
                             :to="{ path: `/users/${user.id}/collections` }">My Collections
                </router-link>
                <router-link class="navbar-text"
                             :to="{ path: `/users/${user.id}/collections/create` }">Add Collection
                </router-link>
                <a class="navbar-text" href="" @click.prevent="$emit('logout')">Logout</a>
            </section>
        </nav>
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    import SearchForm from './SearchForm.vue';

    export default {
        props: ['appName'],

        components: { SearchForm },

        computed: {
            ...mapState(['user']),

            isGuest() {
                return !Object.keys(this.user).length;
            }
        }
    }
</script>
