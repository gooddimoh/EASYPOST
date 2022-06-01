import replace from './replace.json';
import { dictionary, settings } from './settings';

const i18n = {
    translate: (word) => dictionary[word] || word,

    language() {
        return this.settings.toString();
    },
    change: settings.change,
    settings,
};

const withTranslation = (label) => i18n.translate(label.replaceAll(replace));

const t = i18n.translate;

export { withTranslation, i18n, t };
