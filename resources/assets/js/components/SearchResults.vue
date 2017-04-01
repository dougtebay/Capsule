<template>
    <div>
        <section class="search-result" v-for="result in results">
            <div>@{{ result.user_nickname }}</div>
            <div>{{ result.text }}</div>
        </section>
    </div>
</template>

<script>
    import eventHub from './../app.js'

    export default {
        data() {
            return {
                results: []
            }
        },

        created() {
            eventHub.$on('results-found', results => {
                this.results = results
            })
        }
    }
</script>
