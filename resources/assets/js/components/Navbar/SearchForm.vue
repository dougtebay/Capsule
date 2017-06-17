<template>
    <form class="navbar-search-form">
        <input type="text" name="query" v-model="query">
        <router-link :to="{ path: '/search', query: { userId: user.id, query: query }}">
            <button>Search</button>
        </router-link>
    </form>
</template>

<script>
    export default {
        props: ['user'],

        data () {
            return {
                query: ''
            }
        }
    }
</script>
