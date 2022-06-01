import Constants from '../Constants';

export const submitFilterAction =
    (dispatch, { service }) =>
    async (data) => {
        dispatch({ type: Constants.GRAPH_DATA_REQUESTED });
        const { serviceKey, requestOnSubmit } = service;
        try {
            const result = await requestOnSubmit(data);
            dispatch({ type: Constants.GRAPH_DATA_SUCCESSED, data: { key: serviceKey, value: result } });
            return result;
        } catch (error) {
            dispatch({ type: Constants.GRAPH_DATA_FAILED, data: error });
        }
        return false;
    };
