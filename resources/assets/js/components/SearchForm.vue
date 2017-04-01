<template>
    <form class="navbar-search-form">
        <input type="text" name="query" v-model="query">
        <button @click.prevent="search()">Search</button>
    </form>
</template>

<script>
    import eventHub from './../app.js'

    export default {
        data() {
            return {
                query: ''
            }
        },

        methods: {
            search() {
                axios.get('/search', { params: { query: this.query }
                }).then(function (response) {
                    eventHub.$emit('results-found', {
                        query: this.query,
                        results: response.data
                    })
                }.bind(this))
            }
        }
    }
</script>
