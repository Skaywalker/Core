// import './bootstrap';
import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        let page = null;

        let isModule = name.split("::");
        if (isModule.length > 1) {
            let module = isModule[0];
            let pathTo = isModule[1];
            console.log('module', module, 'pathTo', pathTo+'.vue',`@Modules/`);
            // @modules is an alias of the module folder or just specify the path
            // from the root directory to the folder modules
            // for example ../../modules
            page = require(`@modules/${module}/${pathTo}.vue`);
        } else {
            page = require(`./Pages/${name}`);
        }
        //...
        return page.default;
        // return resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));
    },
    setup: function ({el, App, props, plugin})  {
        const app = createApp({render: () => h(App, props)})
            .use(plugin);

        app.mount(el);

        return app;
    },
    progress: {
        color: '#4B5563',
    },
}).then(r => {});