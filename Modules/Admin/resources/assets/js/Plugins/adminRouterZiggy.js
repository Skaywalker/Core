import Router from 'ziggy-js/src/js/Router.js';
import Route from 'ziggy-js/src/js/Route.js';
import {AdminRouter} from './adminRoutes.js';
export default class adminRouterZiggy extends Router{

    constructor(name, params, absolute = true, config) {
        super();

        this._config = config ?? globalThis?.AdminRouter ?? AdminRouter;
        this._config = { ...this._config, absolute };
        if (name) {
            if (!this._config.routes[name]) {
                throw new Error(`adminRoutes error: route '${name}' is not in the route list.`);
            }

            this._route = new Route(name, this._config.routes[name], this._config);
            this._params = this._parse(params);
        }
    }
}