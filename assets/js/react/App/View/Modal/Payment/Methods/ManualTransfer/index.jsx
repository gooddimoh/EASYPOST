import React from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { schema } from 'Services';
import { accountVerifyType } from 'Services/Enums';
import NotExist from './Views/NotExist';
import NotVerify from './Views/NotVerify';
import Verify from './Views/Verify';

const views = schema({
    [accountVerifyType.notExist]: (_, onChange) => <NotExist onChange={onChange} />,
    [accountVerifyType.notVerify]: (_, onChange) => <NotVerify onChange={onChange} />,
    [accountVerifyType.verify]: (onSubmit) => <Verify onSubmit={onSubmit} />,
});

const ManualTransfer = ({ onSubmit, onChange, accountView }) => views(accountView)(onSubmit, onChange);

ManualTransfer.propTypes = {
    onSubmit: PropTypes.func.isRequired,
    onChange: PropTypes.func.isRequired,
    accountView: PropTypes.string.isRequired,
};

const mapStateToProps = (state, { service: { getStoreItem } }) => ({
    accountView: getStoreItem(state, ['payment', 'accountView'], ''),
});

export default compose(withTagDefaultProps, connect(mapStateToProps))(ManualTransfer);
