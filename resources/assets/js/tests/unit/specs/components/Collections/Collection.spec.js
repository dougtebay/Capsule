import { expect } from 'chai';
import { mount } from 'avoriaz';
import Collection from '../../../../../components/Collections/Collection.vue';

describe('Collection.vue', () => {
    const wrapper = mount(Collection, { propsData: {
        collection: [
            { id: 1, title: 'Fake Title', description: 'Fake description' }
        ]
    }});

    it('renders correct contents', () => {
        expect(wrapper.text()).contains('View');
    });
});
