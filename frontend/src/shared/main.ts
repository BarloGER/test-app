import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import { router } from "./router.ts"
import {createI18n} from 'vue-i18n';
// TODO: Import error beseitigen
import en from '@shared/locales/en.json'
import de from '@shared/locales/de.json'

const i18n = createI18n({
    legacy: false,
    locale: 'de',
    fallbackLocale: 'en',
    messages: {
        en,
        de
    }
})

createApp(App).use(i18n).use(router).mount('#app')
