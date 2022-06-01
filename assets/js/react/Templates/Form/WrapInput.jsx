import React, { Children, cloneElement, useRef } from 'react';
import PropTypes from 'prop-types';
import { uniqueGenerator } from 'Services';
import { withTagDefaultProps } from 'Hoc/Template';
import Label from './Label';
import InputDescription from './InputDescription';

const propTypes = {
    name: PropTypes.string.isRequired,
    label: PropTypes.string,
    description: PropTypes.string,
    disabled: PropTypes.bool,
    required: PropTypes.bool,
    reverse: PropTypes.bool,
    errors: PropTypes.arrayOf(PropTypes.string),
};

const defaultProps = {
    label: '',
    description: '',
    disabled: false,
    required: false,
    reverse: false,
    errors: [],
};

const WrapInput = ({ pref, name, label, description, disabled, required, children, errors, reverse, t }) => {
    const _name = useRef(`${name}_${uniqueGenerator(5)}`);
    return (
        <div className={`wrap-input wrap-input_${pref} ${reverse ? 'wrap-input_reverse' : ''}`}>
            {label && <Label name={_name.current} label={label} required={required} />}
            {Children.map(children, (child) => {
                return cloneElement(child, {
                    name: _name.current,
                    disabled,
                    inputProps: {
                        ...child.props.inputProps,
                        'data-error': !!errors.length,
                    },
                });
            })}
            {!!errors.length &&
                errors.map((err) => {
                    return (
                        <div
                            className={`wrap-input__warning wrap-input__warning_${pref}`}
                            key={`${name}_${uniqueGenerator(5)}`}
                        >
                            {t(err)}
                        </div>
                    );
                })}
            {description && <InputDescription text={description} />}
        </div>
    );
};

WrapInput.propTypes = propTypes;
WrapInput.defaultProps = defaultProps;

export default withTagDefaultProps(WrapInput);
