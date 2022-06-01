import React, { lazy, Suspense, useCallback } from 'react';
import PropTypes from 'prop-types';
import { compose, equals } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { showPaymentModal, close, info } from 'Widgets/Modal';
import { schema, schemaCall } from 'Services';
import { ServiceProvider } from 'Services/Context';
import { modalViewsEnum, serverResponseCode, paymentType } from 'Services/Enums';
import service from './Services';

const LabelRates = lazy(() => import('./Views/LabelRates'));
const PickupForm = lazy(() => import('./Views/PickupForm'));
const Successfully = lazy(() => import('./Views/Successfully'));
const PickupRates = lazy(() => import('./Views/PickupRates'));

const propTypes = {
    kModal: PropTypes.string.isRequired,
    currentScreen: PropTypes.string.isRequired,
    requestGetBalance: PropTypes.func.isRequired,
    nextModalScreen: PropTypes.func.isRequired,
    createDraft: PropTypes.func,
};

const defaultProps = {
    createDraft: () => {},
};

const renderScreen = schema({
    [modalViewsEnum.labelRates]: (submit) => <LabelRates submit={submit} />,
    [modalViewsEnum.pickupForm]: () => <PickupForm />,
    [modalViewsEnum.pickupRates]: (submit) => <PickupRates submit={submit} />,
    [modalViewsEnum.success]: () => <Successfully />,
});

const payTransfer = async (kModal, createDraft) => {
    await createDraft();
    close(kModal);
    info({
        text: 'We have saved this label as a draft, you can continue your purchase when the funds are credited to your account.',
    });
};

const payDefault = async (call, updateBalance) => {
    const next = await call();
    if (next) updateBalance();
};

const handleSuccess = schemaCall({
    [paymentType.autoTransfer]: ({ kModal, createDraft }) => payTransfer(kModal, createDraft),
    [paymentType.manualTransfer]: ({ kModal, createDraft }) => payTransfer(kModal, createDraft),
    _: ({ call, updateBalance }) => payDefault(call, updateBalance),
});

const LabelModal = ({ kModal, currentScreen, requestGetBalance, nextModalScreen, createDraft }) => {
    const updateBalance = useCallback(async () => {
        await requestGetBalance();
        nextModalScreen();
    }, []);

    const requestToBuyRate = async (call, method = null) => {
        try {
            await handleSuccess(method, { call, updateBalance, kModal, createDraft });
        } catch (error) {
            if (equals(error.code, serverResponseCode.amountExceed)) {
                showPaymentModal((_method) => {
                    requestToBuyRate(call, _method);
                });
            }
        }
    };

    return (
        <ServiceProvider value={{ ...service, kModal }}>
            <Suspense fallback={<div />}>{renderScreen(currentScreen)(requestToBuyRate)}</Suspense>
        </ServiceProvider>
    );
};

LabelModal.propTypes = propTypes;
LabelModal.defaultProps = defaultProps;

const mapStateToProps = (state) => {
    return {
        currentScreen: service.getStoreItem(state, ['currentScreen'], ''),
    };
};

const mapDispatchToProps = () => {
    return {
        requestGetBalance: service.getActionStore('requestGetBalance'),
        nextModalScreen: service.getActionStore('nextModalScreen'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(LabelModal);
