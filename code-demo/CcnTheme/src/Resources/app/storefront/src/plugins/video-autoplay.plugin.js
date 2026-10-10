import Plugin from 'src/plugin-system/plugin.class';

const win = window;

/**
 * Video autoplay trigger to circumvent browser restrictions.
 * Emulates user interaction; e.g. useful for hero video animations.
 */
export default class CcnVideoAutoplayPlugin extends Plugin {
    static options = {
        distance: '100px',
        events: ['keydown', 'pointerdown'],
    };

    init() {
        this._registerEvents();
    }

    /**
     * @private
     */
    _registerEvents() {
        const events = this.options.events;

        events.forEach((event) => {
            this._registerEvent(event);
        });
    }

    /**
     * @param event {Event}
     * @private
     */
    _registerEvent(event) {
        win.addEventListener(event, this._play.bind(this), {
            passive: true,
            once: true,
        });
    }

    /**
     * @param event {Event}
     * @private
     */
    _play(event) {
        const video = this.el;

        // noinspection JSIgnoredPromiseFromCall
        this._awaitVisibility(() => {
            // ...
        });
    }

    /**
     * @param video {HTMLVideoElement}
     * @private
     */
    _setAttributes(video) {
        video.volume = 0;
        // ...
    }

    /**
     * @param callback {Function}
     * @private
     */
    async _awaitVisibility(callback) {
        // const observer = new IntersectionObserver
    }
}
