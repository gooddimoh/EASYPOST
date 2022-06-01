import { changeForm } from 'Services/Store';
import Constants from '../Constants';

const commonLayout = {
    total: {
        items: [],
    },
    graph: {},
};

export const initState = {
    credit: commonLayout,
    carrier: commonLayout,
};

export const reducer = {
    [Constants.GRAPH_DATA_REQUESTED]: () => ({ formLoading: true }),
    [Constants.GRAPH_DATA_SUCCESSED]: changeForm,
    [Constants.GRAPH_DATA_FAILED]: () => ({ formLoading: false }),
};
