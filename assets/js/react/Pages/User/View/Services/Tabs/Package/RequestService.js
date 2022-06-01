import { generateKeyRender } from 'Services';
import { requestOnSubmit } from '../../RequestService';
import { columnsForPackages } from '../../index';

export const requestPackagesTable = (url) => async () => {
    const res = await requestOnSubmit(url)({});
    const { items } = generateKeyRender(res);

    return {
        items,
        columns: columnsForPackages,
        pagination: {},
    };
};
