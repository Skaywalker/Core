// import './bootstrap';
import {createApp,  h} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from "laravel-vite-plugin/inertia-helpers";
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async(name):Promise<any> =>{
        let parts = name.split('::')
        let type = false
        if (parts.length > 1) {
            type = !!parts[0]
        }
        if (type) {
            let nameVue:string = parts[1].split('.')[0];
           return  await resolvePageComponent(`../../../../${parts[0]}/${parts[1]}.vue`, import.meta.glob([
                `../../../../**/resources/assets/js/Pages/*.vue`,
            ]));
        }else {
           return  await resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob([
                './Pages/**/*.vue',
            ]));
        }

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
