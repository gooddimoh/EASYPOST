import React from 'react';
import PropTypes from 'prop-types';
import { compose, equals } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { schemaCall, url as _url } from 'Services';
import { serverResponseCode, paymentType } from 'Services/Enums';
import { showPaymentModal, showRegistrationModal, info } from 'Widgets/Modal';
import { TableWidget } from 'Widgets/Table';
import { BorderButton } from 'Templates/Button';

const propTypes = {
    onLinkPackage: PropTypes.func.isRequired,
    requestGetBalance: PropTypes.func.isRequired,
    confirmed: PropTypes.bool.isRequired,
    activePackage: PropTypes.string,
};

const defaultProps = {
    activePackage: '',
};

const payTransfer = () => {
    info({ text: 'You will be able to buy the package when the funds are credited to your account.' });
};

const payDefault = async (onLinkPackage, id, requestGetBalance) => {
    const res = await onLinkPackage({ package: id });
    if (res) {
        await requestGetBalance();
    }
};

const handleSuccess = schemaCall({
    [paymentType.autoTransfer]: ({ kModal, onSuccess }) => payTransfer(kModal, onSuccess),
    [paymentType.manualTransfer]: ({ kModal, onSuccess }) => payTransfer(kModal, onSuccess),
    _: ({ onLinkPackage, id, requestGetBalance }) => payDefault(onLinkPackage, id, requestGetBalance),
});

const PackagesTable = ({ t, onLinkPackage, requestGetBalance, confirmed, activePackage }) => {
    const checkRegistration = () => {
        const redirect = () => _url.redirect(`/labels`);
        return confirmed ? redirect() : showRegistrationModal(redirect);
    };

    const onSubmit = async (id, method = null) => {
        try {
            await handleSuccess(method, { onLinkPackage, id, requestGetBalance });
            checkRegistration();
        } catch (error) {
            if (equals(error.code, serverResponseCode.amountExceed)) {
                showPaymentModal((_method) => {
                    onSubmit(id, _method);
                });
            }
        }
    };

    const checkActivePackage = ({ id }) => {
        if (id === activePackage) {
            info({ text: 'You have already selected this package.' });
            return;
        }
        onSubmit(id);
    };

    const _config = {
        isVertical: true,
        activeItem: activePackage,
    };

    const buttons = [
        <BorderButton key="choose-plan" name="choose-plan" onClick={({ id }) => checkActivePackage({ id })}>
            {t('Choose plan')}
        </BorderButton>,
    ];

    return <TableWidget key={activePackage} config={_config} buttons={buttons} />;
};

PackagesTable.propTypes = propTypes;
PackagesTable.defaultProps = defaultProps;

const mapStateToProps = (state) => ({
    activePackage: state.userState.activePackage,
    confirmed: state.userState.confirmed,
});

const mapDispatchToProps = ({ service: { getActionStore } }) => ({
    onLinkPackage: getActionStore('onLinkPackage'),
    requestGetBalance: getActionStore('requestGetBalance'),
});

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(PackagesTable);
