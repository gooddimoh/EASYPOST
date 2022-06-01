import React from "react";
import PropTypes from "prop-types";
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    placeholder: PropTypes.string,
    value: PropTypes.string,
    name: PropTypes.string.isRequired,
    onChange: PropTypes.func.isRequired,
    inputProps: PropTypes.objectOf(PropTypes.any),
    t: PropTypes.func.isRequired
};

const defaultProps = {
    placeholder: "",
    value: "",
    inputProps: {},
};

const TextArea = ({ placeholder, value, onChange, inputProps, name, t }) => (
    <textarea id={name} name={name} placeholder={t(placeholder)} onChange={onChange} value={value} {...inputProps} className={`${inputProps.className} input_textarea`} />
);

TextArea.propTypes = propTypes;
TextArea.defaultProps = defaultProps;

export default withTagDefaultProps(TextArea);
