<template>
    <div class="navbar-container">
    	<nav class="navbar">
    		<section>
    	        <a class="navbar-text" href="/">{{ appName }}</a>
    	    </section>
        	<section v-if="guest">
            	<a class="navbar-text" href="/login">Login</a>
        	</section>
        	<section v-if="user">
        		<search-form @search="search"></search-form>
    	        <span class="navbar-text">{{ user.name }}</span>
    	        <a class="navbar-text" href="" @click.prevent="$emit('get-collections')">Collections</a>
                <a class="navbar-text" href="" @click.prevent="$emit('logout')">Logout</a>
        	</section>
    	</nav>
    </div>
</template>

<script>
    import SearchForm from './SearchForm.vue';

	export default {
		props: ['appName', 'user'],

        components: {
            SearchForm
        },

		computed: {
			guest: function () {
				return !this.user
			}
		},

        methods: {
            search (query) {
                this.$emit('search', query)
            }
        }
	}
</script>
