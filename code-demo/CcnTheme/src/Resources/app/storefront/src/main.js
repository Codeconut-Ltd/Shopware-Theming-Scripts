const PluginManager = window.PluginManager;

PluginManager.register(
    'CcnVideoAutoplayPlugin',
    () => import('./plugins/video-autoplay.plugin'),
    '[data-ccn-video-autoplay]',
);
