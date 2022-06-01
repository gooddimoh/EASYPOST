import { serviceProps } from 'Services';
import { getStoreItem, getActionStore } from './StoreService';
import { requestTable, requestOnSubmit } from './RequestService';
import { formData } from './FormService';

const divideGraphValues = (data) => {
    Object.keys(data).map((k) => (data[k] = { items: data[k].items.map((el) => ({ ...el, value: el.value / 100 })) }));
    return data;
};

const divideTotalValues = (items) => items.map(({ name, value }) => ({ name, value: value / 100 }));

const divideTotal = (items) => items.map(({ name, value }) => ({ name: name.replace('_', ' '), value: value / 100 }));

const getTotalFromItems = (items) => {
    const value = items.reduce((acc, current) => acc + current.value, 0);
    return [{ name: 'total', value }, ...items];
};

const url = 'statistics';

export default serviceProps(url, 'statistics', {
    requestOnSubmit,
    requestTable,
    formData,
    divideTotal,
    divideGraphValues,
    divideTotalValues,
    getTotalFromItems,
    getStoreItem,
    getActionStore,
});
