import React from "react";
import PropTypes from "prop-types";
import { withTagDefaultProps } from "Hoc/Template";

const propTypes = {
    pref: PropTypes.string.isRequired,
    children: PropTypes.node.isRequired,
};

const FormRow = ({ pref, children }) => {
    return <div className={`form__row_center form__row_${pref}_center`}>{children}</div>;
};

FormRow.propTypes = propTypes;

export default withTagDefaultProps(FormRow);
