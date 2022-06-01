import Constants from '../Constants';

export const initState = {
    activeTab: 0,
};

export const reducer = {
    [Constants.CHANGE_TAB]: ({ data: { activeTab, filter }, state }) => ({
        activeTab,
        filter,

        items: [],
        pagination: {},
        sort: {},
        columns: [],

        request: 0,
        forceUpdate: state.forceUpdate + 1
    })
};
