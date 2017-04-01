<template>
    <form class="navbar-search-form">
        <input type="text" name="query" v-model="query">
        <button @click.prevent="submit()">Search</button>
    </form>
</template>

<script>
    import eventHub from './../app.js'

    export default {
        data() {
            return {
                query: '',
                results: []
            }
        },

        methods: {
            submit() {
                axios.get('/search', { params: { query: this.query }
                }).then(function (response) {
                    eventHub.$emit('search-results', response.data)
                }.bind(this))
            }
        }
    }
</script>
