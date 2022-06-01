import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    onClick: PropTypes.func.isRequired,
    checked: PropTypes.bool.isRequired,
};

const ThemeSwitcherButton = ({ onClick, checked }) => {
    return (
        <button
            aria-label="theme-switcher"
            type="button"
            onClick={onClick}
            className={`button button_header switcher__btn ${checked ? 'checked' : ''}`}
        >
            <span className="switcher__body" />
            <span className="switcher__shadow">
                    <span />
                </span>
            {[1, 2, 3, 4, 5, 6].map((i) => (
                <span key={`key-${i}`} className={`switcher__line switcher__line--${i}`}>
                        <span />
                    </span>
            ))}
        </button>
    );
};

ThemeSwitcherButton.propTypes = propTypes;

export default withTagDefaultProps(ThemeSwitcherButton);
