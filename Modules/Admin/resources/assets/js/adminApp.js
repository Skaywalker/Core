 import './adminBootstrap.js';
import { createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from "laravel-vite-plugin/inertia-helpers";
import Trans from './Plugins/Translations';
 import { ZiggyVue } from '../../../../../vendor/tightenco/ziggy';


 import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader

import '../scss/app.scss';


// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

 const getComputedStyleValue = (property) => getComputedStyle(document.documentElement).getPropertyValue(property).trim();

 const light = {
     dark: getComputedStyleValue('--light-dark') === 'true',
     colors: {
         background: getComputedStyleValue('--light-colors-background'),
         surface: getComputedStyleValue('--light-colors-surface'),
         'surface-bright': getComputedStyleValue('--light-colors-surface-bright'),
         'surface-light': getComputedStyleValue('--light-colors-surface-light'),
         'surface-variant': getComputedStyleValue('--light-colors-surface-variant'),
         'on-surface-variant': getComputedStyleValue('--light-colors-on-surface-variant'),
         primary: getComputedStyleValue('--light-colors-primary'),
         'primary-darken-1': getComputedStyleValue('--light-colors-primary-darken-1'),
         secondary: getComputedStyleValue('--light-colors-secondary'),
         'secondary-darken-1': getComputedStyleValue('--light-colors-secondary-darken-1'),
         error: getComputedStyleValue('--light-colors-error'),
         info: getComputedStyleValue('--light-colors-info'),
         success: getComputedStyleValue('--light-colors-success'),
         warning: getComputedStyleValue('--light-colors-warning'),
     },
     variables: {
         'border-color': getComputedStyleValue('--light-variables-border-color'),
         'border-opacity': getComputedStyleValue('--light-variables-border-opacity'),
         'high-emphasis-opacity': getComputedStyleValue('--light-variables-high-emphasis-opacity'),
         'medium-emphasis-opacity': getComputedStyleValue('--light-variables-medium-emphasis-opacity'),
         'disabled-opacity': getComputedStyleValue('--light-variables-disabled-opacity'),
         'idle-opacity': getComputedStyleValue('--light-variables-idle-opacity'),
         'hover-opacity': getComputedStyleValue('--light-variables-hover-opacity'),
         'focus-opacity': getComputedStyleValue('--light-variables-focus-opacity'),
         'selected-opacity': getComputedStyleValue('--light-variables-selected-opacity'),
         'activated-opacity': getComputedStyleValue('--light-variables-activated-opacity'),
         'pressed-opacity': getComputedStyleValue('--light-variables-pressed-opacity'),
         'dragged-opacity': getComputedStyleValue('--light-variables-dragged-opacity'),
         'theme-kbd': getComputedStyleValue('--light-variables-theme-kbd'),
         'theme-on-kbd': getComputedStyleValue('--light-variables-theme-on-kbd'),
         'theme-code': getComputedStyleValue('--light-variables-theme-code'),
         'theme-on-code': getComputedStyleValue('--light-variables-theme-on-code'),
     }
 };

 const dark = {
     dark: getComputedStyleValue('--dark-dark') === 'true',
     colors: {
         background: getComputedStyleValue('--dark-colors-background'),
         surface: getComputedStyleValue('--dark-colors-surface'),
         'surface-bright': getComputedStyleValue('--dark-colors-surface-bright'),
         'surface-light': getComputedStyleValue('--dark-colors-surface-light'),
         'surface-variant': getComputedStyleValue('--dark-colors-surface-variant'),
         'on-surface-variant': getComputedStyleValue('--dark-colors-on-surface-variant'),
         primary: getComputedStyleValue('--dark-colors-primary'),
         'primary-darken-1': getComputedStyleValue('--dark-colors-primary-darken-1'),
         secondary: getComputedStyleValue('--dark-colors-secondary'),
         'secondary-darken-1': getComputedStyleValue('--dark-colors-secondary-darken-1'),
         error: getComputedStyleValue('--dark-colors-error'),
         info: getComputedStyleValue('--dark-colors-info'),
         success: getComputedStyleValue('--dark-colors-success'),
         warning: getComputedStyleValue('--dark-colors-warning'),
     },
     variables: {
         'border-color': getComputedStyleValue('--dark-variables-border-color'),
         'border-opacity': getComputedStyleValue('--dark-variables-border-opacity'),
         'high-emphasis-opacity': getComputedStyleValue('--dark-variables-high-emphasis-opacity'),
         'medium-emphasis-opacity': getComputedStyleValue('--dark-variables-medium-emphasis-opacity'),
         'disabled-opacity': getComputedStyleValue('--dark-variables-disabled-opacity'),
         'idle-opacity': getComputedStyleValue('--dark-variables-idle-opacity'),
         'hover-opacity': getComputedStyleValue('--dark-variables-hover-opacity'),
         'focus-opacity': getComputedStyleValue('--dark-variables-focus-opacity'),
         'selected-opacity': getComputedStyleValue('--dark-variables-selected-opacity'),
         'activated-opacity': getComputedStyleValue('--dark-variables-activated-opacity'),
         'pressed-opacity': getComputedStyleValue('--dark-variables-pressed-opacity'),
         'dragged-opacity': getComputedStyleValue('--dark-variables-dragged-opacity'),
         'theme-kbd': getComputedStyleValue('--dark-variables-theme-kbd'),
         'theme-on-kbd': getComputedStyleValue('--dark-variables-theme-on-kbd'),
         'theme-code': getComputedStyleValue('--dark-variables-theme-code'),
         'theme-on-code': getComputedStyleValue('--dark-variables-theme-on-code'),
     }
 };

const vuetify = createVuetify({
    icons: {
        defaultSet: 'mdi',

    },
    components,
    directives,
    theme:{
        defaultTheme: 'light',
        themes: {
            light,dark
        },
    }
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
        if (type && parts[0] !== 'Admin') {
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
            .use(ZiggyVue)
            .mount(el)
    },
    progress: {
        color: '#4B5563',
    },

});