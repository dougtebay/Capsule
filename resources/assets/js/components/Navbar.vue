<template>
	<nav class="header">
		<section>
	        <a class="header-text" :href="appUrl">{{ appName }}</a>
	    </section>
    	<section v-if="guest">
        	<a class="header-text" :href="loginUrl">Login</a>
    	</section>
    	<section v-if="user">
    		<form method="GET" action="/search">
            	<input type="text" name="query">
            	<button type="submit">Search</button>
        	</form>
    	</section>
    	<section>
	        <span class="header-text">{{ user.name }}</span>
	        <a class="header-text"
	           :href="logoutUrl"
	           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
	            Logout
	        </a>
	        <form id="logout-form" class="hidden" method="POST" :action="logoutUrl">
	            <input type="hidden" name="_token" :value="csrfToken">
	        </form>
    	</section>
	</nav>
</template>

<script>
	export default {
		props: ['appName', 'appUrl', 'csrfToken', 'user'],

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
		}
	}
</script>
