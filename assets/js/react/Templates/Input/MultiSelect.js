import * as R from 'ramda';
import React from "react";
import PropTypes from "prop-types";
import { withTagDefaultProps } from 'Hoc/Template';
import Select from "react-select";

const propTypes = {
    disabled: PropTypes.bool,
    placeholder: PropTypes.string,
    name: PropTypes.string.isRequired,
    value: PropTypes.oneOfType([
        PropTypes.string,
        PropTypes.arrayOf(PropTypes.string),
    ]),
    onChange: PropTypes.func.isRequired,
    inputProps: PropTypes.shape({
        isOptionDisabled: PropTypes.func,
        options: PropTypes.arrayOf(PropTypes.object),
    }),
    t: PropTypes.func.isRequired
};

const defaultProps = {
    disabled: false,
    placeholder: "",
    value: "",
    inputProps: {
        isOptionDisabled: (option) => option.disable,
        options: []
    },
};

const MultiSelect = ({ disabled, placeholder, onChange, inputProps, name, t }) => {
    const { options } = inputProps;
    inputProps = R.dissocPath(['options'], inputProps);

    return (
        <Select
            id={name}
            name={name}
            isMulti
            isDisabled={disabled}
            menuPosition="fixed"
            closeMenuOnScroll={(e) => !e.target.parentNode.className.includes("menu")}
            options={options}
            className="select-custom-wrap basic-multi-select custom-select"
            isClearable={false}
            onChange={(value) => onChange(value ? value.map((v) => v.value) : value)}
            classNamePrefix="custom-select"
            placeholder={t(placeholder)}
            {...inputProps}
        />
    );
};

MultiSelect.propTypes = propTypes;
MultiSelect.defaultProps = defaultProps;

export default withTagDefaultProps(MultiSelect);
