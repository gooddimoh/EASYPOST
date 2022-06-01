import React from 'react';
import { toast } from 'react-toastify';
import Notice from 'Templates/Notice';

const ErrorNotification = ({ title, text }) => toast.error(<Notice title={title} text={text} />);

export default ErrorNotification;
