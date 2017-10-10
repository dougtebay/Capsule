import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: {},
        collections: []
    },

    mutations: {
        setUser(state, { user }) {
            state.user = user;
        },

        setCollections(state, { collections }) {
            state.collections = collections;
        },

        addCollection(state, { collection }) {
            state.collections.push(collection);
        },

        deleteCollection(state, { collection }) {
            state.collections.splice(state.collections.indexOf(collection), 1);
        }
    },

    actions: {
        getCollections({ state }) {
            return new Promise((resolve, reject) => {
                axios.get(`/api/users/${state.user.id}/collections`)
                    .then(response => resolve(response))
                    .catch(() => reject());
            });
        },

        createCollection({ state }, { collection }) {
            return new Promise((resolve, reject) => {
                axios.post(`/api/users/${state.user.id}/collections`, collection)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },

        deleteCollection({ state }, { collection }) {
            return new Promise((resolve, reject) => {
                axios.delete(`/api/users/${state.user.id}/collections/${collection.id}`)
                    .then(() => resolve(collection))
                    .catch(() => reject());
            });
        }
    }
});
