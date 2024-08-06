export function trans(key, replacements = {}) {
    let translation = window._translations[key] || key

    Object.keys(replacements).forEach((replacement) => {
        translation = translation.replace(
            `:${replacement}`,
            replacements[replacement]
        )
    })

    return translation
}
export default {
    install: (app, options) => {

        const t=(key, replacements =options)=>trans(key, replacements)
        app.config.globalProperties.trans = t
        app.provide('trans', t)
    }
}
