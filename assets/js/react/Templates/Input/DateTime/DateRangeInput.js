import React, { useState } from 'react';
import { dissocPath } from 'ramda';
import PropTypes from 'prop-types';
import { DateUtils } from 'react-day-picker';
import DayPickerInput from 'react-day-picker/DayPickerInput';
import { formatDate, parseDate } from 'react-day-picker/moment';
import { formatDate as formatDateService } from 'Services';

const propTypes = {
    value: PropTypes.oneOfType([PropTypes.string, PropTypes.arrayOf(PropTypes.string)]).isRequired,
    onChange: PropTypes.func.isRequired,
    inputProps: PropTypes.objectOf(PropTypes.any),
    dayPickerProps: PropTypes.objectOf(PropTypes.any),
    dateFormat: PropTypes.string,
    name: PropTypes.string.isRequired,
    placeholder: PropTypes.string,
    className: PropTypes.string.isRequired,
};

const defaultProps = {
    dateFormat: 'YYYY-MM-DD',
    placeholder: 'DD.MM',
    inputProps: {
        viewFormat: 'DD.MM',
    },
    dayPickerProps: {}
};

const CustomOverlay =
    (handleResetClick, handleSearchClick) =>
    ({
        // eslint-disable-next-line react/prop-types
        classNames,
        selectedDay,
        hideDayPicker,
        children,
        ...props
    }) => {
        return (
            // eslint-disable-next-line react/prop-types,react/jsx-no-comment-textnodes
            <div className={classNames.overlayWrapper} style={{ marginLeft: -100 }} {...props}>
                {/* eslint-disable-next-line react/prop-types */}
                <div className={classNames.overlay}>
                    {/* eslint-disable-next-line react/prop-types */}
                    <div className={`${classNames.overlay}-buttons-container`}>
                        {/* eslint-disable-next-line react/prop-types */}
                        <button className={`${classNames.overlay}-button`} type="button" onClick={handleResetClick}>
                            Reset
                        </button>
                        {/* eslint-disable-next-line react/prop-types */}
                        <button className={`${classNames.overlay}-button`} type="button" onClick={handleSearchClick}>
                            Search
                        </button>
                    </div>
                    {children}
                </div>
            </div>
        );
    };

const DateRangeInput = ({ value, onChange, inputProps, placeholder, dateFormat, className, name, dayPickerProps }) => {
    const [[from = '', to = ''], setRange] = useState(Array.isArray(value) ? value : [value]);

    const { viewFormat } = inputProps;
    inputProps = dissocPath(['viewFormat'], inputProps);

    const handleDayClick = (day) => {
        const range = DateUtils.addDayToRange(day, { from, to });
        setRange([range.from, range.to]);
        onChange({ target: { value: [`${range.from}`] } });
    };

    const getDateRangeString = (_from, _to) => {
        const fromStr = formatDateService(_from, viewFormat) || '';
        const toStr = formatDateService(_to, viewFormat) || '';

        if (fromStr === toStr) {
            return fromStr;
        }
        return `${fromStr} - ${toStr}`;
    };

    const handleResetClick = () => {
        setRange(['', '']);
        onChange({ target: { value: [''] } });
    };

    const handleSearchClick = () => {
        if (!to) return;
        const requestValue = [formatDateService(from, dateFormat), formatDateService(to, dateFormat)];
        onChange({ target: { value: requestValue } });
    };

    return (
        <DayPickerInput
            name={name}
            value={getDateRangeString(from, to)}
            inputProps={{
                readOnly: true,
                className,
                ...inputProps,
            }}
            formatDate={formatDate}
            keepFocus
            format={viewFormat}
            parseDate={parseDate}
            placeholder={placeholder}
            overlayComponent={CustomOverlay(handleResetClick, handleSearchClick)}
            hideOnDayClick={false}
            dayPickerProps={{
                ...dayPickerProps,
                className: 'DayPicker',
                selectedDays: [from, { from, to }],
                modifiers: {
                    start: from,
                    end: to,
                },
                onDayClick: handleDayClick,
            }}
        />
    );
};

DateRangeInput.propTypes = propTypes;
DateRangeInput.defaultProps = defaultProps;

export default DateRangeInput;
