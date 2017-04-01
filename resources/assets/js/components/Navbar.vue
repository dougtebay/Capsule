<template>
	<nav class="navbar">
		<section>
	        <a class="navbar-text" :href="appUrl">{{ appName }}</a>
	    </section>
    	<section v-if="guest">
        	<a class="navbar-text" :href="loginUrl">Login</a>
    	</section>
    	<section v-if="user">
    		<search-form></search-form>
	        <span class="navbar-text">{{ user.name }}</span>
	        <a class="navbar-text"
	           :href="logoutUrl"
	           @click.prevent="logout">
	            Logout
	        </a>
	        <form id="logout-form" class="hidden" method="POST" :action="logoutUrl">
	            <input type="hidden" name="_token" :value="csrfToken">
	        </form>
    	</section>
	</nav>
</template>

<script>
    import SearchForm from './SearchForm.vue';

	export default {
		props: ['appName', 'appUrl', 'csrfToken', 'user'],

        components: {
            SearchForm
        },

		computed: {
			guest: function() {
				return !this.user
			},
			loginUrl: function() {
				return `${this.appUrl}/login`
			},
			logoutUrl: function() {
				return `${this.appUrl}/logout`
			}
		},

        methods: {
            logout() {
                document.getElementById('logout-form').submit()
            }
        }
	}
</script>
