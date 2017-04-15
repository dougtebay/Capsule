
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
import SearchIndex from './components/Search/Index.vue'
import CollectionsIndex from './components/Collections/Index.vue'
import CollectionsCreate from './components/Collections/Create.vue'
import CollectionsShow from './components/Collections/Show.vue'

Vue.use(VueRouter)

const routes = [
	{ path: '/search', name: 'search', component: SearchIndex },
	{ path: '/collections', component: CollectionsIndex },
	{ path: '/collections/create', component: CollectionsCreate },
	{ path: '/collections/:id', component: CollectionsShow, props: true }
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
