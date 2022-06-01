import Constants from '../Constants';

export const onClickTab = (dispatch) => (id) => (activeTab) => {

    dispatch({
        type: Constants.CHANGE_TAB,
        data: { activeTab, filter: { companyId: id } },
    });
};
