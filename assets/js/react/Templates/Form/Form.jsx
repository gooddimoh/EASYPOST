import React from "react";
import PropTypes from "prop-types";
import { withTagDefaultProps } from "Hoc/Template";

const propTypes = {
    onSubmit: PropTypes.func,
};

const defaultProps = {
    onSubmit: () => {},
};

const Form = ({ pref, onSubmit, children }) => {
    const _onSubmit = (e) => {
        e.preventDefault();
        onSubmit();
    };
    return (
        <form action="/" onSubmit={_onSubmit} className={`form form_${pref}`}>
            {children}
        </form>
    );
};

Form.defaultProps = defaultProps;
Form.propTypes = propTypes;

export default withTagDefaultProps(Form);
