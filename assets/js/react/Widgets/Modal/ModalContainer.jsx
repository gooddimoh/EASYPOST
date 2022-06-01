import React, {useState, useEffect, Fragment} from 'react';
import {Portal} from 'Hoc/Template';
import {Event, eventManager} from './eventManager';

const stackModal = new Map();

export const ModalContainer = () => {
    const [state, setState] = useState({ render: true });
    const render = (call) => (...arg) => {
        call(...arg);
        state.render = !state.render;
        setState({ ...state });
    };

    useEffect(() => {
        eventManager.on(
            Event.Show,
            render(({ view, key }) => stackModal.set(key, view))
        );

        eventManager.on(
            Event.Close,
            render((key => stackModal.delete(key)))
        );
    }, []);

    if (!state) return null;

    return <Portal> {[...stackModal].map(([k, i]) => <Fragment key={k}>{i}</Fragment>)} </Portal>;
};
