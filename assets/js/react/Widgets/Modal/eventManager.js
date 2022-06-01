import {EventEmitter} from 'events';
import {nanoid} from "nanoid";

export const Event = {
    Show: 0,
    Close: 1,
};

const eventManager = new EventEmitter();

const show = (view, onClose) => {
    const key = nanoid(8);

    const close = (_key) => {
        if (_key !== key) {
            return;
        }

        if (onClose) {
            onClose();
        }

        eventManager.off(Event.Close, close);
    };

    eventManager.emit(Event.Show, { view: view(key), key });
    eventManager.on(Event.Close, close);

    return key;
};

const close = (key) => eventManager.emit(Event.Close, key);

export {
    eventManager,
    close,
    show,
};
