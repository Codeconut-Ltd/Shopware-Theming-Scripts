/**
 * Content order = A-Z (by component name) for a logical admin view.
 * # = Overrides
 */

// Global styles
import './scss/base.scss';

// MODULES / CMS

// Components
import './module/sw-cms/components/sw-cms-sidebar'; // #

// Blocks
import './module/sw-cms/blocks/categories-slider';

// Elements
import './module/sw-cms/elements/categories-slider';

// LOCALE
import deDE from './module/sw-cms/snippet/de-DE.json';
import enGB from './module/sw-cms/snippet/en-GB.json';

Shopware.Locale.extend('de-DE', deDE);
Shopware.Locale.extend('en-GB', enGB);
