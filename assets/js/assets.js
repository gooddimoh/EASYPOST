import {compose} from "redux";
// eslint-disable-next-line import/extensions
import replace from "./replace";

const imagesCtx = require.context('../images', false, /\.(png|jpg|jpeg|gif|svg|webp)$/);
const iconsCtx = require.context('../icons', false, /\.svg$/);

const files = {};
const icons = {};

const load = (context, value) => filename => {
    const key = filename.replace(/^.{2}/, '').replace(/.{4}$/, '');
    value[key] = context(filename);
};

imagesCtx.keys().forEach(load(imagesCtx, files));
iconsCtx.keys().forEach(load(iconsCtx, icons));


const replaceFile = (key) => replace[key] || key;


const getFile = (key) => {
    try {
        return files[key] ? files[key].default : icons[key].default;
    } catch (e) {
        console.error(`Not found: [${key}].`, e);
    }

    return null;
};

export default compose(
    getFile,
    replaceFile
);


