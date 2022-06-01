import {
    statusEnum,
    rowsPerPageOptions,
    permissionsEnum,
    roleOptions as _roleOptions,
    statusEnumColorOptions as _statusEnumColorOptions,
    statusEnumOptions,
    userStatus,
    userStatusOptions,
    userStatusColorOptions,
} from './general';
import {
    addressBookType,
    addressBookTypeOptions as _addressBookTypeOptions,
    addressTypeOptions as _addressTypeOptions,
} from './addressBook';
import { labelTypeOptions as _labelTypeOptions, trackingServices, labelType } from './label';
import { paymentType, paymentMethods as _paymentMethods, balanceAmount, accountVerifyType } from './payment';
import { transactionType, transactionTypeOptions, transactionStatus, transactionStatusOptions } from './transaction';
import { companyType, companyTypeOptions as _companyTypeOptions } from './company';
import { carriersPermission, carriersType } from './carriers';
import { serverResponseCode } from './Errors/index';
import { modalViewsEnum } from './Modal/index';

const getListValuesWrapper = (list) => {
    list.getListValues = (banList = []) => list.filter((el) => !banList.includes(el.value));
    return list;
};

const addressBookTypeOptions = getListValuesWrapper(_addressBookTypeOptions);
const addressTypeOptions = getListValuesWrapper(_addressTypeOptions);
const labelTypeOptions = getListValuesWrapper(_labelTypeOptions);
const paymentMethods = getListValuesWrapper(_paymentMethods);
const companyTypeOptions = getListValuesWrapper(_companyTypeOptions);
const roleOptions = getListValuesWrapper(_roleOptions);
const statusEnumColorOptions = getListValuesWrapper(_statusEnumColorOptions);

export {
    addressBookType,
    addressBookTypeOptions,
    addressTypeOptions,
    modalViewsEnum,
    labelType,
    labelTypeOptions,
    trackingServices,
    paymentType,
    paymentMethods,
    balanceAmount,
    accountVerifyType,
    transactionType,
    transactionTypeOptions,
    transactionStatus,
    transactionStatusOptions,
    companyType,
    companyTypeOptions,
    rowsPerPageOptions,
    permissionsEnum,
    roleOptions,
    statusEnum,
    statusEnumOptions,
    userStatus,
    userStatusOptions,
    userStatusColorOptions,
    statusEnumColorOptions,
    carriersPermission,
    carriersType,
    serverResponseCode,
};
