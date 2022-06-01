export const requestNormalizer = (item) => {
    return ({...item.credentials, name:item.name});
};

export const responseNormalizer = (data) => {

    const _items = data.items.map(item => ({
        ...item,
        credentials: JSON.parse(item.credentials),
    }));

    return {...data, items: _items};
};