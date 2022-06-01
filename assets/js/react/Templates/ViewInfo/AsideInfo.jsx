import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { AsideLink, AsideEnum, AsideDefault } from './AsideItems';

const propTypes = {
    type: PropTypes.string,
    value: PropTypes.string.isRequired,
    title: PropTypes.string.isRequired,
    options: PropTypes.oneOfType([
        PropTypes.arrayOf(PropTypes.any),
        PropTypes.shape({}),
    ]),
    children: PropTypes.node
};

const defaultProps = {
    children: null,
};

const cond = {
    link: (value, title, {href}, children) => <AsideLink href={href} value={value} title={title}>{children}</AsideLink>,
    email: (value, title) => <AsideLink href={`mailto:${value}`} value={value} title={title} />,
    phone: (value, title) => <AsideLink href={`tel:${value}`} value={value} title={title} />,
    enum: (value, title, options) => <AsideEnum options={options} value={value} title={title} />,
    default: (value, title) => <AsideDefault value={value} title={title} />,
};

const AsideInfo = ({ type, value, title, options, children }) => {
    if (!cond[type]) return cond.default(value, title, options);
    return cond[type](value, title, options, children);
};

AsideInfo.propTypes = propTypes;
AsideInfo.defaultProps = defaultProps;

export default withTagDefaultProps(AsideInfo);