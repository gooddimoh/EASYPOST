import React from 'react';
import * as R from 'ramda';
import PropTypes from 'prop-types';
import DayPickerInput from 'react-day-picker/DayPickerInput';
import { formatDate, parseDate } from 'react-day-picker/moment';
import { formatDate as formatDateService } from 'Services';

const propTypes = {
    value: PropTypes.string,
    className: PropTypes.string,
    onChange: PropTypes.func.isRequired,
    inputProps: PropTypes.objectOf(PropTypes.any),
    dateFormat: PropTypes.string,
    placeholder: PropTypes.string,
    name: PropTypes.string.isRequired,
};

const defaultProps = {
    value: '',
    className: '',
    dateFormat: 'YYYY-MM-DD',
    placeholder: 'DD.MM.YYYY',
    inputProps: {
        viewFormat: 'DD.MM.YYYY',
    },
};

export const CustomOverlay =
    (onChange) =>
        // eslint-disable-next-line react/prop-types
    ({ classNames, selectedDay, children, ...props }) => {
        return (
            // eslint-disable-next-line react/prop-types,react/jsx-no-comment-textnodes
            <div className={classNames.overlayWrapper} style={{ marginLeft: -100 }} {...props} >
                {/* eslint-disable-next-line react/prop-types */}
                <div className={classNames.overlay}>
                    <p>
                        <button
                            // eslint-disable-next-line react/prop-types
                            className={`${classNames.overlay}-button`}
                            type="button"
                            onClick={() => {
                                onChange('');
                            }}
                        >
                            Reset
                        </button>
                    </p>
                    {children}
                </div>
            </div>
        );
    };

const DateInput = ({ value, onChange, inputProps, placeholder, dateFormat, name, className }) => {
    const _onChange = (day) => {
        onChange({ target: { value: day ? formatDateService(day, dateFormat) : '' } });
    };

    const { viewFormat } = inputProps;
    inputProps = R.dissocPath(['viewFormat'], inputProps);

    return (
        <DayPickerInput
            name={name}
            selectedDays={value}
            value={value ? formatDate(value, viewFormat) : value}
            inputProps={{
                readOnly: true,
                ...inputProps,
                className,
            }}
            formatDate={formatDate}
            keepFocus
            format={viewFormat}
            parseDate={parseDate}
            placeholder={placeholder}
            overlayComponent={CustomOverlay(_onChange)}
            onDayChange={_onChange}
        />
    );
};

DateInput.propTypes = propTypes;
DateInput.defaultProps = defaultProps;

export default DateInput;
