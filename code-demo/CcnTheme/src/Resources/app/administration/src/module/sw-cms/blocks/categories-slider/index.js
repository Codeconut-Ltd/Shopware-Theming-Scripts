import data from './data';

const { Component } = Shopware;

const GLOBAL = data.GLOBAL;
const DEFAULTS = GLOBAL.defaults;

const SLOTS = {
    slider: data.elementName,
};


Component.register(data.componentName, () => import('./component'));
// ...

Shopware.Service('cmsService').registerCmsBlock({
    category: GLOBAL.category.id,
    // ...
    defaultConfig: { ...DEFAULTS.config.block },
    slots: SLOTS,
});
