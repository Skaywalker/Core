import './bootstrap';
import '../../Modules/Main/resources/assets/js/app.js';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

const appName = 'Laravel' || import.meta.env.VITE_APP_NAME;
console.log('kisfeketekacsa dsajgh')
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        let parts = name.split('::')
        let type = false
        if (parts.length > 1) {
            type = parts[0]
        }
        console.log(import.meta.glob([
            `../../Modules/**/resources/assets/js/Pages/*.vue`]));
        if (type) {
            let nameVue = parts[1].split('.')[0];
            return resolvePageComponent(`../../Modules/${parts[0]}/${parts[1]}.vue`, import.meta.glob([
                `../../Modules/**/resources/assets/js/Pages/*.vue`,
            ]));
        }else {
            return resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob([
                './Pages/**/*.vue',
            ]));
        }
        // return resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));
    },
    setup: function ({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            .use(plugin)

            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
}).then(r => {});