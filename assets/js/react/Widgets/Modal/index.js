import React from 'react';
import { curry, __, when, is, assoc } from 'ramda';
import Payment from 'App/View/Modal/Payment';
import Registration from 'App/View/Modal/Registration';
import { Alert, Confirm } from './Templates';
import { show, close } from './eventManager';
import Modal from './Templates/Modal';

export const info = (props, onClose) => show(Alert(props), onClose);

export const ask = (text, onResolve, onReject) => {
    const props = when(is(String), assoc('text', __, {}));

    return show(Confirm(props(text), onResolve, onReject));
};

export const showModalButtonParams = curry((Component, buttons, params, onClose) =>
    show(Modal(Component, buttons, params), onClose),
);

export const showModalButtons = showModalButtonParams(__, __, null);

export const showModal = (Component, onClose) => showModalButtonParams(Component, [], null, onClose);

export const showPaymentModal = (onSuccess, onClose) =>
    showModalButtons(<Payment title="Add Funds" onSuccess={onSuccess} />, [], onClose);

export const showRegistrationModal = (onSuccess, onClose) =>
    showModalButtons(<Registration title="Complete your registration" onSuccess={onSuccess} />, [], onClose);

export { close };
