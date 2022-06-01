import { combineReducers as _combineReducers } from 'redux';
import userReducer, { initState as userState } from '../Reducers/UserReducer';
import modalReducer, { initState as modalState } from '../Reducers/Modal';
import { getUserStoreItem, getModalStoreItem, getModalActionStore } from './StoreService';

export const mapStateToProps = () => ({});

export const dispatchStateToProps = () => ({});

export const combineStore = ({ user = {} }, pageState) => ({
    userState: { ...userState, ...user },
    modalState,
    pageState,
});

export const combineReducers = (pageReducer) =>
    _combineReducers({
        userState: userReducer,
        modalState: modalReducer,
        pageState: pageReducer,
    });

export { getUserStoreItem, getModalStoreItem, getModalActionStore };
