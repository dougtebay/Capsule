
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import VueRouter from 'vue-router'
import SearchResults from './components/SearchResults.vue'
import Collections from './components/Collections.vue'

Vue.use(VueRouter)

const routes = [
	{ path: '/search', component: SearchResults },
	{ path: '/collections', component: Collections }
]

const router = new VueRouter({
	mode: 'history',
	routes: routes
})

const eventHub = new Vue()
export default eventHub

Vue.component('app', require('./components/App.vue'))

const app = new Vue({
    el: '#app',
    router: router
})
