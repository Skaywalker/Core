// import './bootstrap';
import { createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from "laravel-vite-plugin/inertia-helpers";
import Trans from './Plugins/Translations';
// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'



const vuetify = createVuetify({
    components,
    directives,
})


//@ts-ignore
const appName = 'Laravel' || import.meta.env.VITE_APP_NAME;

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        let parts = name.split('::')
        let type = false
        if (parts.length > 1) {
            type = !!parts[0]
        }
        if (type && parts[0] !== 'Website') {
            return await resolvePageComponent(`../../../../${parts[0]}/${parts[1]}.vue`, import.meta.glob([
                `../../../../**/resources/assets/js/Pages/*.vue`,
            ]));
        } else {

            let page = parts[1].split('js')
            return await resolvePageComponent(`.${page[1]}.vue`, import.meta.glob([
                `../../../../**/resources/assets/js/Pages/*.vue`,]));
        }

    },
    setup: function ({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(vuetify)
            .use(Trans)
            .mount(el)


    },
    progress: {
        color: '#4B5563',
    },

})