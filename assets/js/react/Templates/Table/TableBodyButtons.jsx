import React, { cloneElement } from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    buttons: PropTypes.arrayOf(PropTypes.node).isRequired,
    pref: PropTypes.string.isRequired,
    item: PropTypes.objectOf(PropTypes.any).isRequired,
};

const TableBodyButtons = ({ buttons, pref, item }) => {
    return (
        <div className={`main-table__buttons main-table__buttons_${pref}`}>
            {buttons.map((element) => cloneElement(element, {
                onClick: () => element.props.onClick(item),
                isShow: () => element.props.isShow ? element.props.isShow(item) : true,
            }))}
        </div>
    );
};

TableBodyButtons.propTypes = propTypes;

export default withTagDefaultProps(TableBodyButtons);
