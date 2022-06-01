import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    name: PropTypes.string.isRequired,
    value: PropTypes.oneOfType([
        PropTypes.string,
        PropTypes.arrayOf(PropTypes.string),
    ]),
    className: PropTypes.string,
    onChange: PropTypes.func.isRequired,
    placeholder: PropTypes.string,
    inputProps: PropTypes.objectOf(PropTypes.any),
    disabled: PropTypes.bool,
    t: PropTypes.func.isRequired,
};

const defaultProps = {
    disabled: false,
    placeholder: '',
    value: '',
    className: '',
    inputProps: {},
};

const MagnifyGlassWrap = ({ name, placeholder, disabled, value, onChange, inputProps, className, t }) => {
    return (
        <div className="magnify-glass">
            <input
                {...inputProps}
                id={name}
                type="search"
                name={name}
                disabled={disabled}
                placeholder={t(placeholder)}
                value={value}
                onChange={onChange}
                className={className}
            />
        </div>
    );
};

MagnifyGlassWrap.propTypes = propTypes;
MagnifyGlassWrap.defaultProps = defaultProps;

export default withTagDefaultProps(MagnifyGlassWrap);
