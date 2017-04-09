
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
import SearchResults from './components/SearchResults/SearchResults.vue'
import Collections from './components/Collections/Collections.vue'
import Collection from './components/Collection/Collection.vue'

Vue.use(VueRouter)

const routes = [
	{ path: '/search', name: 'search', component: SearchResults },
	{ path: '/collections', name: 'collections', component: Collections },
	{ path: '/collections/:id', name: 'collection', component: Collection, props: true }
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
