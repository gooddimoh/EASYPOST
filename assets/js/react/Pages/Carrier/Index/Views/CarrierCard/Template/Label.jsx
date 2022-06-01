import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import PropTypes from 'prop-types';

const propTypes = {
    t: PropTypes.func.isRequired,
    flagLabel: PropTypes.bool.isRequired,
};

const Label = ({ flagLabel, t }) => {
    return (
        <div className="carrier-card__label">
            <span>{t(`${flagLabel ? 'Customer' : 'Default'}`)}</span>
        </div>
    );
};

Label.propTypes = propTypes;

export default withTagDefaultProps(Label);
