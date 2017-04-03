<template>
    <form class="navbar-search-form">
        <input type="text" name="query" v-model="query">
        <button @click.prevent="$emit('search', query)">Search</button>
    </form>
</template>

<script>
    export default {
        data () {
            return {
                query: ''
            }
        }
    }
</script>
