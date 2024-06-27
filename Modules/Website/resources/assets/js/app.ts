// import './bootstrap';
import { createApp, h,DefineComponent} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from "laravel-vite-plugin/inertia-helpers";

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'



const vuetify = createVuetify({
    components,
    directives,
})


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name): Promise<any> => {
        let parts: string[] = name.split('::')
        let type: boolean = false
        if (parts.length > 1) {
            type = !!parts[0]
        }
        if (type && parts[0] !== 'Website') {
            return await resolvePageComponent(`../../../../${parts[0]}/${parts[1]}.vue`, import.meta.glob<DefineComponent>([
                `../../../../**/resources/assets/js/Pages/*.vue`,
            ]));
        } else {
            let page: string[] = parts[1].split('js')
            return await resolvePageComponent(`.${page[1]}.vue`, import.meta.glob<DefineComponent>([
                `../../../../**/resources/assets/js/Pages/*.vue`,]));
        }

    },
    setup: function ({el, App, props, plugin}): any {
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(vuetify)
            .mount(el);

    },
    progress: {
        color: '#4B5563',
    },

}).then(r =>{})