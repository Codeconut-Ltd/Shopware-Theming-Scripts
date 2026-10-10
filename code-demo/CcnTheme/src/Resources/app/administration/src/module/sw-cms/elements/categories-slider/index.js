import data from './data';

const { Component } = Shopware;

Component.register(data.componentName, () => import('./component'));
// ...

Shopware.Service('cmsService').registerCmsElement({
    name: data.name,
    // ...
    defaultConfig: { ...data.defaultConfig },
});
