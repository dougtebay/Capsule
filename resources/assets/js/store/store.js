import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: {},
        userCollections: {}
    },

    mutations: {
        setUser(state, { user }) {
            state.user = user;
        },

        setUserCollections(state, { userCollections }) {
            state.userCollections = userCollections;
        }
    },

    actions: {
        getUserCollections({ state }) {
            return new Promise((resolve, reject) => {
                axios.get(`/api/users/${state.user.id}/collections`)
                    .then(response => {
                        this.commit('setUserCollections', { userCollections: response.data });
                        resolve();
                    })
                    .catch(() => reject());
            });
        }
    }
});
