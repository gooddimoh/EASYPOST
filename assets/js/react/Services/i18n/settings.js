const settings = {
    value: localStorage.getItem('i18n') || 'en',

    valueOf () {
        return this.value;
    },

    toString () {
        return this.valueOf();
    },

    change (lang) {
        this.value = lang;
        localStorage.setItem('i18n', lang);
    },
};

const dictionaries = () => {
    // eslint-disable-next-line import/no-dynamic-require,global-require
    return require(`./translations/${settings}/translation.json`);
};

const dictionary = dictionaries();

export { settings, dictionary };
