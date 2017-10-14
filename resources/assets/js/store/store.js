import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: {},
        collections: []
    },

    getters: {
        getCollection: (state) => (collectionId) => {
            return state.collections.find(collection => collection.id == collectionId);
        }
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

        updateCollection(state, payload) {
            state.collections.forEach(collection => {
                if (collection.id === payload.collection.id) {
                    let index = state.collections.indexOf(collection)
                    state.collections.splice(index, 1, payload.collection);
                }
            });
        },

        deleteCollection(state, { collection }) {
            state.collections.splice(state.collections.indexOf(collection), 1);
        },

        setTweets(state, payload) {
            state.collections.forEach(collection => {
                if (collection.id === payload.collection.id) {
                    Vue.set(collection, 'tweets', payload.tweets);
                }
            });
        },

        deleteTweet(state, payload) {
            payload.collection.tweets.forEach(tweet => {
                if (tweet.id === payload.tweet.id) {
                    let index = payload.collection.tweets.indexOf(payload.tweet);
                    payload.collection.tweets.splice(index, 1);
                }
            });
        },
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

        updateCollection({ state, commit }, { collection }) {
            return new Promise((resolve, reject) => {
                axios.put(`/api/users/${state.user.id}/collections/${collection.id}`, collection)
                    .then(response => {
                        commit('updateCollection', { collection: response.data });
                        resolve();
                    })
                    .catch(error => reject(error));
            });
        },

        deleteCollection({ state }, { collection }) {
            return new Promise((resolve, reject) => {
                axios.delete(`/api/users/${state.user.id}/collections/${collection.id}`)
                    .then(() => resolve(collection))
                    .catch(() => reject());
            });
        },

        getTweets({ commit }, { collection }) {
            return new Promise((resolve, reject) => {
                axios.get(`/api/collections/${collection.id}/tweets`)
                    .then(response => {
                        commit('setTweets', { collection, tweets: response.data });
                        resolve();
                    })
                    .catch(() => reject());
            });
        },

        deleteTweet({ commit }, { collection, tweet }) {
            return new Promise((resolve, reject) => {
                axios.delete(`/api/collections/${collection.id}/tweets/${tweet.id}`)
                    .then(() => {
                        commit('deleteTweet', { collection, tweet });
                        resolve();
                    })
                    .catch(() => reject());
            });
        }
    }
});
