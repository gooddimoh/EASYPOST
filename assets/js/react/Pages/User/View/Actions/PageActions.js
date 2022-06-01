import Constants from '../Constants';

export const onClickTab =
    (dispatch) =>
    (id) =>
    (activeTab, filter = {}) => {
        dispatch({
            type: Constants.CHANGE_TAB,
            data: {
                activeTab,
                filter: {
                    ...filter,
                    userId: id,
                },
            },
        });
    };

export const onLinkPackage =
    (dispatch, { service }) =>
    async (data) => {
        const { id } = await service.requestLinkPackage(data);
        if (id) {
            dispatch({ type: Constants.PACKAGE_LINK_PLAN, data: id });
        }
        return id;
    };
