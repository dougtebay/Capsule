import VueRouter from 'vue-router';

let routes = [
		{
			path: '/search', name: 'search',
			component: require('./components/Search/Index')
		},
		{
			path: '/users/:userId/collections',
			component: require('./components/Collections/Index'),
			props: true
		},
		{
			path: '/users/:userId/collections/create',
			component: require('./components/Collections/Create'),
			props: true
		},
		{
			path: '/users/:userId/collections/:collectionId',
			component: require('./components/Collections/Show'),
			props: true
		},
		{
			path: '/users/:userId/collections/:collectionId/edit',
			component: require('./components/Collections/Edit'),
			props: true
		}
];

export default new VueRouter({
	mode: 'history',
	routes: routes
});
