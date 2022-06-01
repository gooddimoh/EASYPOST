import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    activeTab: PropTypes.bool.isRequired,
    label: PropTypes.string.isRequired,
    onClick: PropTypes.func.isRequired,
    pref: PropTypes.string.isRequired,
};

const Tab = ({ activeTab, label, onClick, pref, t }) => (
    <button
        type="button"
        className={`tabs__control tabs__control_${pref} ${activeTab ? 'tabs__control_active' : ''}`}
        onClick={onClick}
    >
        {t(label)}
    </button>
);

Tab.propTypes = propTypes;

export default withTagDefaultProps(Tab);
