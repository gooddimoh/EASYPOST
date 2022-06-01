import { getStoreItem as _getStoreItem, getActionStore as _getActionStore } from 'Services';
import ModalActions from '../Actions/Modal/Payment';

export const getUserStoreItem = _getStoreItem('userState');
export const getModalStoreItem = _getStoreItem('modalState');

export const getModalActionStore = _getActionStore(ModalActions);
