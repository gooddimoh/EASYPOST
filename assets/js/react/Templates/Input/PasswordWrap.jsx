import React, { useState } from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { Img } from 'Templates/Img';

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

const PasswordWrap = ({ name, placeholder, disabled, value, onChange, inputProps, className, t }) => {
    const [showPassword, handlerShowPassword] = useState(false);
    const onClickShowPassword = () => handlerShowPassword(!showPassword);

    return (
        <div className="password-wrap">
            <input
                {...inputProps}
                id={name}
                type={showPassword ? 'text' : 'password'}
                name={name}
                disabled={disabled}
                placeholder={t(placeholder)}
                value={value}
                onChange={onChange}
                className={className}
            />
            <button
                type="button"
                tabIndex="-1"
                aria-label="show-control"
                onClick={onClickShowPassword}
                className="password-wrap__btn"
            >
                <Img img={showPassword ? 'icon_unshow_password' : 'icon_show_password'} alt={t("eye")} />
            </button>
        </div>
    );
};

PasswordWrap.propTypes = propTypes;
PasswordWrap.defaultProps = defaultProps;

export default withTagDefaultProps(PasswordWrap);
