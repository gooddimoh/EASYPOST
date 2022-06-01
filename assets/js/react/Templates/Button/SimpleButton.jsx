import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { Img } from 'Templates/Img';

const propTypes = {
    name: PropTypes.string.isRequired,
    type: PropTypes.string,
    disabled: PropTypes.bool,
    onClick: PropTypes.func,
    pref: PropTypes.string.isRequired,
    title: PropTypes.string.isRequired,
    iconLeft: PropTypes.string,
};

const defaultProps = {
    type: 'button',
    disabled: false,
    onClick: () => {},
    iconLeft: '',
};

const SimpleButton = ({ name, type, disabled, onClick, title, pref, iconLeft, t }) => {
    return (
        <button
            aria-label={name}
            type={type}
            disabled={disabled}
            onClick={onClick}
            className={`button button_simple button_${pref}`}
        >
            {iconLeft && <Img img={iconLeft} alt="button-icon" className="icon-left" />}
            <span>{t(title)}</span>
        </button>
    );
};

SimpleButton.propTypes = propTypes;
SimpleButton.defaultProps = defaultProps;

export default withTagDefaultProps(SimpleButton);
