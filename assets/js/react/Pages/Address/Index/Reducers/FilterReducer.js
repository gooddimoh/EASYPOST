import { replaceFilter } from 'Services';
import Constants from "../Constants";

export const initState = {
    filter: {
        type: '1'
    },
};

export const reducer = {
    [Constants.CHANGE_FILTER]: replaceFilter,
    [Constants.TABLE_UPDATE]: ({ data }) => data,
};
