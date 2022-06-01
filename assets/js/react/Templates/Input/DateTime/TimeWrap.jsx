import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import {Img} from '../../Img';
import Time from './Time';

const propTypes = {
    name: PropTypes.string.isRequired,
    value: PropTypes.oneOfType([
        PropTypes.string,
        PropTypes.arrayOf(PropTypes.string),
    ]),
    className: PropTypes.string,
    onChange: PropTypes.func.isRequired,
    placeholder: PropTypes.string,
    inputProps: PropTypes.objectOf(PropTypes.any),
    t: PropTypes.func.isRequired
};

const defaultProps = {
    placeholder: '',
    value: '',
    className: '',
    inputProps: {},
};

const TimeWrap = ({ name, placeholder, value, onChange, inputProps, className, t  }) => {
    return (
        <div className="magnify-glass">
            <Img img="icon_clock" alt="search" />
            <Time
                name={name}
                placeholder={t(placeholder)}
                value={value}
                onChange={onChange}
                inputProps={inputProps}
                className={className}
            />
        </div>
    );
};

TimeWrap.propTypes = propTypes;
TimeWrap.defaultProps = defaultProps;

export default withTagDefaultProps(TimeWrap);
