import React from 'react';
import { BorderButton } from 'Templates/Button';
import { DefaultModal as AlertView } from 'Templates/Modal/Template';
import { WrapButton } from 'Templates/Modal';
import Modal from './Modal';

const Button = WrapButton(BorderButton);

export default (props) => Modal(
    // eslint-disable-next-line react/jsx-props-no-spreading
    <AlertView {...props} />,
    [ <Button name="ok">OK</Button> ],
    null
);
