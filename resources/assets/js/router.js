import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/search',
            name: 'search',
            component: require('./components/Search/Index.vue')
        },
        {
            path: '/users/:userId/collections',
            component: require('./components/Collections/Index.vue'),
            props: true
        },
        {
            path: '/users/:userId/collections/create',
            component: require('./components/Collections/Create.vue'),
            props: true
        },
        {
            path: '/users/:userId/collections/:collectionId',
            component: require('./components/Collections/Show.vue'),
            props: true
        },
        {
            path: '/users/:userId/collections/:collectionId/edit',
            component: require('./components/Collections/Edit.vue'),
            props: true
        }
    ]
});
