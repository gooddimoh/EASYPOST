import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import {Img} from '../../Img';
import DateRangeInput from './DateRangeInput';

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
    dayPickerProps: PropTypes.objectOf(PropTypes.any),
    t: PropTypes.func.isRequired
};

const defaultProps = {
    placeholder: '',
    value: '',
    className: '',
    inputProps: {},
    dayPickerProps: {}
};

const DateRangeInputWrap = ({ name, placeholder, value, onChange, inputProps, className, dayPickerProps, t }) => {
    return (
        <div className="magnify-glass">
            <Img img="icon_calendar" alt="calendar" />
            <DateRangeInput
                {...inputProps}
                name={name}
                placeholder={t(placeholder)}
                value={value}
                onChange={onChange}
                inputProps={inputProps}
                className={className}
                dayPickerProps={dayPickerProps}
            />
        </div>
    );
};

DateRangeInputWrap.propTypes = propTypes;
DateRangeInputWrap.defaultProps = defaultProps;

export default withTagDefaultProps(DateRangeInputWrap);
