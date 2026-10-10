/**
 * category.id: Also set in 'sw_cms_sidebar_block_overview_category_options'
 */
const _category = {
    id: 'ccn',
    label: 'Theme: Codeconut',
};

/**
 * Generic config - Any components.
 */
const GLOBAL = {
    category: _category,
    defaults: {
        config: {
            block: {
                marginTop: null,
            },
        },
        slots: {
            media: {
            },
            text: {
                type: 'text',
                default: {
                },
            },
        },
    },
};

export default GLOBAL;

export const blockConfig = (name, label) => {
    return {
        GLOBAL: GLOBAL,
        // ...
    };
};
