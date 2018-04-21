import Vuex from 'vuex';
import expect from 'expect';
import { createLocalVue, mount } from 'vue-test-utils';
import Collection from 'js/components/Collections/Collection.vue';

describe('Collection', () => {
    const localVue = createLocalVue();
    localVue.use(Vuex);

    const store = new Vuex.Store({state: {user: {id: 1}}});

    const wrapper = mount(Collection, {
        store,
        localVue,
        propsData: {
            collection: [
                { id: 1, title: 'Fake Title', description: 'Fake description' }
            ]
        }
    });

    it('renders correct contents', () => {
        expect(wrapper.html()).toContain('View');
    });
});
