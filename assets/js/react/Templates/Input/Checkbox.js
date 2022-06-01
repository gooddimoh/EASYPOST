import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { omit, compose, ifElse, reject, equals, append, __, always, includes, F } from 'ramda';

const propTypes = {
    value: PropTypes.arrayOf(PropTypes.string),
    disabled: PropTypes.bool,
    name: PropTypes.string.isRequired,
    onChange: PropTypes.func.isRequired,
    inputProps: PropTypes.shape({
        isOptionDisabled: PropTypes.func,
        options: PropTypes.arrayOf(PropTypes.object).isRequired,
    }),
};

const defaultProps = {
    disabled: false,
    value: [''],
    inputProps: {
        isOptionDisabled: (option) => option.disable,
        options: [],
    },
};

const Checkbox = ({ onChange, inputProps, value, name, t, pref }) => {
    const { options, isOptionDisabled = F } = inputProps;
    inputProps = omit(['options', 'isOptionDisabled'], inputProps);

    const _value = Array.isArray(value) ? value : [value];
    const isChecked = includes(__, _value);

    const _onChange = (val) => {
        const getValue = always(val.target.value);

        const unChecked = (v) => reject(equals(v), _value);
        const checked = append(__, _value);

        compose(onChange, ifElse(isChecked, unChecked, checked), getValue)();
    };

    return options.map((item, k) => {
        return (
            <div key={`${name}_${k}`} className={`checkbox checkbox_${pref}`}>
                <input
                    className={`checkbox__input checkbox__input_${pref}`}
                    type="checkbox"
                    id={`${name}_${k}`}
                    name={name}
                    value={item.value}
                    checked={isChecked(item.value)}
                    onChange={_onChange}
                    disabled={isOptionDisabled(item)}
                    {...inputProps}
                />
                <label htmlFor={`${name}_${k}`} className={`checkbox__label checkbox__label_${pref}`}>
                    {t(item.label || item.value || '')}
                </label>
            </div>
        );
    });
};

Checkbox.propTypes = propTypes;
Checkbox.defaultProps = defaultProps;

export default withTagDefaultProps(Checkbox);
