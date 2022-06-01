import React from 'react';
import { omit } from 'ramda';
import Select from 'react-select';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    isSearchable: PropTypes.bool,
    disabled: PropTypes.bool,
    placeholder: PropTypes.string,
    name: PropTypes.string.isRequired,
    value: PropTypes.string,
    onChange: PropTypes.func.isRequired,
    inputProps: PropTypes.shape({
        isOptionDisabled: PropTypes.func,
        options: PropTypes.arrayOf(PropTypes.object).isRequired,
    }),
    t: PropTypes.func.isRequired,
};

const defaultProps = {
    isSearchable: false,
    disabled: false,
    placeholder: '',
    value: '',
    inputProps: {
        isOptionDisabled: (option) => option.disable,
        options: [],
    },
};

const SearchSelect = ({ isSearchable, disabled, value, placeholder, onChange, inputProps, name, t }) => {
    const { options } = inputProps;
    inputProps = omit(['options'], inputProps);

    return (
        <Select
            name={name}
            id={name}
            isSearchable={isSearchable}
            isDisabled={disabled}
            className="custom-select"
            classNamePrefix="custom-select"
            menuPosition="fixed"
            closeMenuOnScroll={(e) => {
                const parent = e.target.parentNode;
                return parent ? !parent.className.includes('menu') : true;
            }}
            value={options.reduce((acc, option) => {
                if (option.value) {
                    if (option.value === value) {
                        return [...acc, option];
                    }
                    return acc;
                }
                if (option.options && Array.isArray(option.options)) {
                    const result = option.options.find((item) => item.value === value);
                    if (typeof result !== 'undefined') {
                        return [...acc, result];
                    }
                }
                return acc;
            }, [])}
            onChange={(_value) => onChange(_value.value)}
            options={options}
            placeholder={t(placeholder)}
            {...inputProps}
        />
    );
};

SearchSelect.propTypes = propTypes;
SearchSelect.defaultProps = defaultProps;

export default withTagDefaultProps(SearchSelect);
