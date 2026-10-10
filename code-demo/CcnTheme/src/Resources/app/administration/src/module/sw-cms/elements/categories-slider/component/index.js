import data from '../data';

import template from './template.html.twig';
import './styles.scss';

const { Mixin } = Shopware;

export default {
    template,

    mixins: [Mixin.getByName('cms-element')],

    inject: ['feature'],

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig(data.name);
            // ...
        },
    },
};
