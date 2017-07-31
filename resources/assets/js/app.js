
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
import CollectionsShow from './components/Collections/Show.vue'
import CollectionsEdit from './components/Collections/Edit.vue'
import CollectionsIndex from './components/Collections/Index.vue'
import CollectionsCreate from './components/Collections/Create.vue'

Vue.use(VueRouter)

const router = new VueRouter({
	mode: 'history',
	routes: [
		{ path: '/search', name: 'search', component: SearchIndex },
		{ path: '/users/:userId/collections', component: CollectionsIndex, props: true },
		{ path: '/users/:userId/collections/create', component: CollectionsCreate, props: true },
		{ path: '/users/:userId/collections/:collectionId', component: CollectionsShow, props: true },
		{ path: '/users/:userId/collections/:collectionId/edit', component: CollectionsEdit, props: true }
	]
})

const eventHub = new Vue()
export default eventHub

Vue.component('app', require('./components/App.vue'))

const app = new Vue({
    el: '#app',
    router: router
})
