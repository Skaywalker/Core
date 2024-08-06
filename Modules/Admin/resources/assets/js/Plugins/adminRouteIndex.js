import adminRouterZiggy from './adminRouterZiggy.js';
import {AdminRouter} from './adminRoutes.js';
import AdminRouterZiggy from "./adminRouterZiggy.js";
export function route(name, params, absolute, config) {
    const router = new AdminRouterZiggy(name, params, absolute, config);

    return name ? router.toString() : router;
}

export const adminRouter = {
    install(app, options) {
        const r = (name, params, absolute,config=options) =>
            route(name, params, absolute,config );

        if (parseInt(app.version) > 2) {
            app.config.globalProperties.route = r;
            app.provide('route', r);
        } else {
            app.mixin({
                methods: {
                    route: r,
                },
            });
        }
    },
};

export function useRoute(defaultConfig) {
    if (!defaultConfig && !globalThis.AdminRouter && typeof AdminRouter === 'undefined') {
        throw new Error(
            'AdminRoute error: missing configuration. Ensure that a `Ziggy` variable is defined globally or pass a config object into the useRoute hook.',
        );
    }

    return (name, params, absolute, AdminRoute = defaultConfig) =>
        route(name, params, absolute, AdminRoute);
}
