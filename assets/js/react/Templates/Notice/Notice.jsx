import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    title: PropTypes.string,
    text: PropTypes.string.isRequired,
};

const defaultProps = {
    title: '',
};

const Notice = ({ title, text, t }) => {
    return (
        <div className="notice">
            <div className="notice__title">{t(title)}</div>
            <div className="notice__text">{t(text)}</div>
        </div>
    );
};

Notice.propTypes = propTypes;
Notice.defaultProps = defaultProps;

export default withTagDefaultProps(Notice);
