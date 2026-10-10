import data from './data';
import template from './template.html.twig';

const { Component } = Shopware;

Component.override('sw-cms-sidebar', {
    template,

    data() {
        return {
            label: data.label,
        };
    },
});
