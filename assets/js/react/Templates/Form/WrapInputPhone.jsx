import React, { Children, cloneElement } from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import Label from './Label';

const propTypes = {
    name: PropTypes.string,
    label: PropTypes.string,
};

const defaultProps = {
    name: '',
    label: '',
};

const WrapInputPhone = ({ pref, name, label, children }) => (
    <div className={`wrap-input_phone wrap-input_phone_${pref}`}>
        {label && <Label name={name} label={label} />}
        {Children.map(children, (child) => cloneElement(child))}
    </div>
);

WrapInputPhone.propTypes = propTypes;
WrapInputPhone.defaultProps = defaultProps;

export default withTagDefaultProps(WrapInputPhone);
