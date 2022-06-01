import React from 'react';
import {BorderButton} from 'Templates/Button';
import { DefaultModal as ConfirmView } from 'Templates/Modal/Template';
import Modal from './Modal';

export default (props, onResolve, onReject) => Modal(
    // eslint-disable-next-line react/jsx-props-no-spreading
    <ConfirmView {...props}/>,
    [
        <BorderButton close name="cancel" onClick={onReject}>Cancel</BorderButton>,
        <BorderButton name="ok" onClick={onResolve}>OK</BorderButton>
    ],
    null
);
