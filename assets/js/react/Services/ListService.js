import { PhoneCodeList, CountryList, StateList } from './CodeList';

const countryListObj = CountryList.reduce((currentValue, item) => {
    currentValue[item.code] = item.name;
    return currentValue;
}, {});

const stateListObj = StateList.reduce((currentValue, item) => {
    currentValue[item.value] = item.label;
    return currentValue;
}, {});

const countryList = CountryList.map((item) => ({
    label: item.name,
    value: item.code,
}));

const phoneList = PhoneCodeList.map((item) => ({
    value: item.dial_code,
    label: `${item.code} ${item.dial_code}`,
}));

export { countryListObj, stateListObj, countryList, phoneList, StateList };
