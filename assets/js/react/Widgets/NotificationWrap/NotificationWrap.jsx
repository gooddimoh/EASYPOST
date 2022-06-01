import React from 'react';
import { toast } from 'react-toastify';
import Notice from 'Templates/Notice';

const NotificationWrap = ({ title, text }) => toast.dark(<Notice title={title} text={text} />);

export default NotificationWrap;
