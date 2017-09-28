<template>
    <div class="navbar-container">
        <nav class="navbar">
            <section>
                <a class="navbar-text" href="/">{{ appName }}</a>
            </section>
            <section v-if="isGuest">
                <a class="navbar-text" href="/login">Login</a>
            </section>
            <section v-if="user">
                <search-form :user="user"></search-form>
                <span class="navbar-text">{{ user.name }}</span>
                <router-link class="navbar-text"
                            :to="{ path: `/users/${user.id}/collections`, params: { userId: user.id }}">
                            My Collections
                </router-link>
                <router-link class="navbar-text"
                             :to="{ path: `/users/${user.id}/collections/create`, params: { userId: user.id }}">
                             Add Collection
                </router-link>
                <a class="navbar-text" href="" @click.prevent="$emit('logout')">Logout</a>
            </section>
        </nav>
    </div>
</template>

<script>
    import SearchForm from './SearchForm.vue';

    export default {
        props: ['appName', 'user'],

        components: { SearchForm },

        computed: {
            isGuest() {
                return !this.user;
            }
        }
    }
</script>
