import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    href: PropTypes.string.isRequired,
    value: PropTypes.string.isRequired,
    title: PropTypes.string.isRequired,
    children: PropTypes.node
};

const defaultProps = {
    children: null,
};

const AsideLink = ({ href, value, title, children, t }) => {
    return (
        <>
            <div className="form-info__profile-block--width">
                <span className="form-info__profile-label">{t(title)}</span>
                {children}
            </div>
            <a className="form-info__profile-link" href={href}>
                {value}
            </a>
        </>
    );
};

AsideLink.propTypes = propTypes;
AsideLink.defaultProps = defaultProps;

export default withTagDefaultProps(AsideLink);
