import Plugin from 'src/plugin-system/plugin.class';

const inflight = new Map();
const MIN_TIMEOUT = 1000;
const MAX_TIMEOUT = 10000;
const DEFAULT_TIMEOUT = 5000;

function isSameOrigin(url) {
    try {
        const u = new URL(url, window.location.href);
        return u.origin === window.location.origin;
    } catch {
        return false;
    }
}

function fetchWithTimeout(url, options = {}, timeoutMs = DEFAULT_TIMEOUT) {
    const controller = new AbortController();
    const timer = setTimeout(() => controller.abort(), timeoutMs);
    return fetch(url, {...options, signal: controller.signal})
        .finally(() => clearTimeout(timer));
}

export default class HvOffcanvasCrossSell extends Plugin {
    init() {
        if (this.el.__hvInit) return;
        this.el.__hvInit = true;

        const rawUrl = this.el?.dataset?.url?.trim();
        if (!rawUrl || !isSameOrigin(rawUrl)) {
            return this._remove();
        }

        const t = parseInt(this.el.dataset.timeout ?? '', 10);
        const timeoutMs = Number.isFinite(t)
            ? Math.min(Math.max(t, MIN_TIMEOUT), MAX_TIMEOUT)
            : DEFAULT_TIMEOUT;

        this.el.setAttribute('aria-busy', 'true');

        const req = inflight.get(rawUrl) ?? fetchWithTimeout(
            rawUrl,
            {
                credentials: 'same-origin',
                headers: {'X-Requested-With': 'XMLHttpRequest'},
            },
            timeoutMs,
        )
            .then(r => (r.ok && r.status !== 204 ? r.text() : ''))
            .finally(() => inflight.delete(rawUrl));

        inflight.set(rawUrl, req);

        req.then(html => {
            if (!html) return this._remove();
            this.el.innerHTML = html;
            try {
                window.PluginManager?.initializePlugins(this.el);
            } catch {
            }
        }).catch(() => this._remove())
            .finally(() => {
                if (document.contains(this.el)) {
                    this.el.setAttribute('aria-busy', 'false');
                }
            });
    }

    _remove() {
        try {
            this.el.remove();
        } catch {
        }
    }
}
