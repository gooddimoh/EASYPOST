import Constants from '../Constants';

export const onClickTab = (dispatch) => (index) => {
    dispatch({ type: Constants.CHANGE_TAB, data: index });
};
