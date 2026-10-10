import data from '../data';

import template from './template.html.twig';

const { Mixin } = Shopware;

export default {
    template,

    inject: ['repositoryFactory'],

    mixins: [Mixin.getByName('cms-element')],

    data() {
        return {};
    },

    created() {
        this.createdComponent();
    },

    methods: {
        async createdComponent() {
            // noinspection JSUnresolvedReference
            this.initElementConfig(data.name);
        },
    },
};
