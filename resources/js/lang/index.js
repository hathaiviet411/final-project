import Vue from 'vue';
import VueI18n from 'vue-i18n';

// File translate
import enLocale from './subs/en';
import viLocale from './subs/vi';

// Function helper
import { getLanguage } from './helper/getLang';

Vue.use(VueI18n);

const messages = {
    en: enLocale,
    vi: viLocale,
};

const i18n = new VueI18n({
    locale: getLanguage(),
    messages,
});

export default i18n;
