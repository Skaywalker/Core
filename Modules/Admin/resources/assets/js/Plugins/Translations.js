export default {
    install: (app, options) => {
        const trans = (key, replacements = {}) => {
            let translation = window._translations[key] || key

            Object.keys(replacements).forEach((replacement) => {
                translation = translation.replace(
                    `:${replacement}`,
                    replacements[replacement]
                )
            })

            return translation
        }

        app.config.globalProperties.trans = trans
        app.provide('translate', trans)
    }
}
