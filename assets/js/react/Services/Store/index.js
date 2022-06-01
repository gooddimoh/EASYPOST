import React from "react";
import * as R from "ramda";
import {nanoid} from "nanoid";
import {assocPath, is} from "ramda";

const memoize = R.memoizeWith( 
    (action, params, { service }) => JSON.stringify([action, params, service]),
    (action, params, options, actions, d) => {
        const _call = actions(d, options);
        return params.length ? _call(...params) : _call;
    });

const changeFilter = R.curry((keys, key, value) => {
    const data = { key, value };

    if (keys.includes(key) || value.length > 2) {
        data.request = true;
    }

    return data;
});

const checkingStore = R.ifElse(
    R.is(Array),
    R.concat,
    R.prepend
);

const pathToValue = (init) => R.compose(
    checkingStore(init),
    R.unless(R.is(Array), R.of)
);

const getStoreItem = (nameStore) => (state, key, _default, link = true) => {
    const linkOrClone = R.unless(R.always(link), R.clone);
    const getValue = R.pathOr(_default, R.__, state);

    return R.compose(
        linkOrClone,
        getValue,
        pathToValue(nameStore)
    )(key);
};

const getActionStore = (actions) => (action, ...params) => {
    const _actions = R.pathOr(R.always(null), [action], actions);
    return (d, options) => memoize(action, params, options, _actions, d);
};

const generateKeyRender = ({ items, ...other }) => {
    items.map((item) => (item._id = item.id || nanoid(5)));

    return {
        items,
        ...other,
    };
};

const replaceFilter = ({ state, data: { key, value, request: isCan, beforeKey = '' } }) => {
    const filterKey = [];
    if(beforeKey) {
        filterKey.push(beforeKey);
    }

    filterKey.push('filter', key);

    const changeValue = R.assocPath(filterKey, R.__, state);
    const deleteKey = () => R.dissocPath(filterKey, state);
    const change = R.ifElse(R.isEmpty, deleteKey, changeValue);

    const canRequest = R.when(R.always(isCan), R.over(R.lensPath(['request']), R.inc));

    return R.compose(
        canRequest,
        change,
    )(value);
};

const schemaCall = list => (key, opt) => {
    const input = list[key] || list._ || R.always(null);
    return input(opt, key);
};

const schemaFilterRender = R.curry((placeholders, inputList) => {
    const _wordbook = schemaCall(inputList);

    return (key, value, callback) => {
        const opt = {
            name: key,
            value,
            placeholder: R.pathOr(key, [key], placeholders),
            onChange: (_value) => callback(key, _value)
        };

        return React.cloneElement(_wordbook(key, opt), opt);
    };
});

const schemaReducer = (init, reducer) => {
    const _wordbook = schemaCall(reducer);

    return (state = init, action) => {
        const { data, type } = action;
        const res = _wordbook(type, { state, data });

        return R.ifElse(R.isNil, R.always(state), R.mergeLeft)(res, state);
    };
};

const schema = R.curry((list, key) => list[key] || list._ || key);

const changeForm = ({ state, data }) => {
    if (!is(Array, data.key)) data.key = [data.key];
    return assocPath(data.key, data.value, state);
};

export {
    schema,
    schemaCall,
    changeFilter,
    pathToValue,
    getStoreItem,
    schemaReducer,
    schemaFilterRender,
    replaceFilter,
    getActionStore,
    generateKeyRender,
    changeForm,
};
