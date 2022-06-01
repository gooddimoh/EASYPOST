import {connect} from 'react-redux';
import {memoizeWith, identity, isEmpty} from 'ramda';

const memoize = memoizeWith(val => JSON.stringify(val), identity);

export default (props, actions) => (Views) => {
    let _data = {};

    const getProps = (...data) => {
        props = props || (() => ({}));
        _data = props(...data);

        Object.freeze(_data);

        return memoize(_data);
    };

    const getActions = (dispatch, ownProps) => {
        actions = actions || (() => {});
        const { service } = ownProps;
        const _actions = actions({ ...ownProps, ..._data }) || {};

        // eslint-disable-next-line no-restricted-syntax
        for(const key in _actions) {
            if(Object.prototype.hasOwnProperty.call(_actions, key)) {
                _actions[key] = _actions[key](dispatch, { service: isEmpty(service) ? _data.service : service });
            }
        }

        return _actions;
    };

    return connect(getProps, getActions)(Views);
};
