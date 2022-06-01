import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    pref: PropTypes.string.isRequired,
    children: PropTypes.node,
    columnSize: PropTypes.number,
    fromColumns: PropTypes.number,
};

const defaultProps = {
    children: null,
    columnSize: 0,
    fromColumns: 0,
};

const FormCol = ({ pref, columnSize, fromColumns, children }) => {
    return <div className={`form__col form__col_${pref} form__col_${columnSize}-${fromColumns}`}>{children}</div>;
};

FormCol.propTypes = propTypes;
FormCol.defaultProps = defaultProps;

export default withTagDefaultProps(FormCol);
