/**
 * Visual highlight of admin CMS module pages.
 * - Pages with specific title prefixes shall not be edited by users;
 *   but remain accessible for staff.
 * - Avoids copies and backup configurations from receiving accidental changes.
 * - Naming convention up to the team (see 'pageNamePrefix').
 *
 * Technical consideration: Lightweight enhancement to work with admin DOM,
 * avoiding nested Twig overrides and their version-specific maintenance.
 * Practical for teams, if no perfection is needed. Easy to reuse across stores.
 * For complex and critical scenarios, a more robust solution might be needed.
 */

const doc = document;
const win = window;

// noinspection LocalVariableNamingConventionJS
export default class CcnCmsHighlightLockedPages {
    #activeUrl = '#/sw/cms/...';
    #linkSelector = 'a[href...]';

    #pageNamePrefix = 'BAK-'; // <- Requires naming convention
    #className = '--disabled';
    #intervalTiming = 1000;
    #interval = null;

    constructor() {
        this.init();
    }

    init() {
        clearInterval(this.#interval);

        this.#interval = setInterval(() => {
            if (!this.canRun()) return;

            this.markLinks();
        }, this.#intervalTiming);
    }

    markLinks() {
        if (!this.canModify()) return;

        const pageNamePrefix = this.#pageNamePrefix;
        const linkSelector = this.#linkSelector;
        const className = this.#className;
        const links = doc.querySelectorAll(linkSelector);

        // links.forEach() ...
    }

    /**
     * @returns {boolean}
     */
    canModify() {
        const linkSelector = this.#linkSelector;
        const hasLink = doc.querySelector(linkSelector);

        if (!hasLink) return false;

        // ...
    }

    /**
     * @returns {boolean}
     */
    canRun() {
        const activeUrl = this.#activeUrl;

        return win.location.hash.startsWith(activeUrl);
    }
}
