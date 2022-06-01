import React from 'react';
import PropTypes from 'prop-types';
import DatePicker from 'react-datepicker';
import { withTagDefaultProps } from 'Hoc/Template';
import { formatDate } from 'Services';
import 'react-datepicker/dist/react-datepicker.css';

const propTypes = {
    onChange: PropTypes.func.isRequired,
    name: PropTypes.string.isRequired,
    placeholder: PropTypes.string,
    value: PropTypes.string.isRequired,
    format: PropTypes.shape({
        time: PropTypes.string,
        dateTime: PropTypes.string,
    }),
    inputProps: PropTypes.objectOf(PropTypes.any),
    className: PropTypes.string,
};

const defaultProps = {
    className: '',
    inputProps: {},
    format: {
        time: 'HH:mm:ss',
        dateTime: 'dd/MM/yyyy HH:mm:ss',
    },
    placeholder: '',
};

const DateTime = ({ format, value, onChange, placeholder, pref, inputProps, name, className }) => {
    const val = Date.parse(formatDate(value, 'MM/DD/YYYY HH:mm:ss', false));

    const _onChange = (_value) => {
        const requestValue = formatDate(_value, 'YYYY-MM-DD HH:mm:ss', false);
        onChange({ target: { value: requestValue } });
    };

    return (
        <div className={`main-timepicker__wrapper ${pref}-timepicker__wrapper`}>
            <DatePicker
                id={name}
                name={name}
                placeholderText={placeholder}
                onChange={_onChange}
                timeIntervals={1}
                timeFormat={format.time}
                dateFormat={format.dateTime}
                selected={val || ''}
                showTimeSelect
                className={className}
                inputProps={{ inputProps }}
            />
        </div>
    );
};

DateTime.propTypes = propTypes;
DateTime.defaultProps = defaultProps;

export default withTagDefaultProps(DateTime);
