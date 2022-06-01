import { NotificationWrap } from 'Widgets/NotificationWrap';

export const listenMessages = (data) => {
    const noticeData = {
        type: 2,
        title: 'New message!',
        text: data.text,
    };

    NotificationWrap(noticeData);
};
