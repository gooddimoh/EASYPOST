import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { IconButton } from '../Button';

const propTypes = {
    onClick: PropTypes.func.isRequired,
    t: PropTypes.func.isRequired,
    title: PropTypes.string,
};

const defaultProps = {
    title: '',
};

const Header = ({ onClick, t, title, pref }) => {
    return (
        <div className={`modal__header modal__header_${pref}`}>
            <div className={`modal__block modal__block_${pref}`}>
                {title && <div className={`modal__title modal__title_${pref}`}>{t(title)}</div>}
            </div>
            <div className={`modal__block modal__block_close modal__block_${pref}`}>
                <IconButton onClick={onClick} title="Close modal" icon="close" />
            </div>
        </div>
    );
};

Header.propTypes = propTypes;
Header.defaultProps = defaultProps;

export default withTagDefaultProps(Header);
