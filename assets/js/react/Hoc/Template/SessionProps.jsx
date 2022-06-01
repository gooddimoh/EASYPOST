import React from "react";
import connect from 'Hoc/Template/Connect';
import {compose} from "redux";

const SessionProps = Wrapped => (props) => {
    return <Wrapped {...props} />;
};

const mapStateToProps = state => {
    return {
        session: state.userState,
    };
};

export default compose(connect(mapStateToProps), SessionProps);
