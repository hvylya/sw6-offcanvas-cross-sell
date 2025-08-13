import HvOffcanvasCrossSell from './plugin/hv-offcanvas-cross-sell.plugin';

function register() {
    window.PluginManager.register('HvOffcanvasCrossSell', HvOffcanvasCrossSell, '[data-hv-offcanvas-cross-sell]');
}

if (window.PluginManager) {
    register();
} else {
    document.addEventListener('DOMContentLoaded', register, { once: true });
}
