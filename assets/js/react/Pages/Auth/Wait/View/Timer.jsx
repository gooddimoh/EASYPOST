import React, {useEffect, useState} from 'react';
import { diffDate, duration, unix } from 'Services';
import { withTagDefaultProps } from 'Hoc/Template';
import PropTypes from 'prop-types';

const propTypes = {
    pref: PropTypes.string.isRequired,
};

const getTime = () => {
    const start = +window.localStorage.banTime;
    const d = 15 * 60 * 1000;
    const finish = start + d;
    const now = Date.now();

    if(finish <= now) {
        window.localStorage.removeItem('banTime');
        window.location.href = window.location.origin;
        return "00:00";
    }

    const diff = diffDate(unix(finish), unix(now), 'seconds');

    return duration(diff);
};

const Timer = ({pref}) => {
    const [blockingTime, setBlockingTime] = useState(getTime());

    const timer = () => {
        setTimeout(() => {
            setBlockingTime(getTime());
            timer();
        }, 1000);
    };

    useEffect(timer, []);

    return (
        <span className={`${pref}__desc-wait-bold timer-test`} id='test'>
            {blockingTime}
        </span>
    );
};

Timer.propTypes = propTypes;

export default withTagDefaultProps(Timer);
