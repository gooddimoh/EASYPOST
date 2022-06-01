import React, { forwardRef } from "react";
import PropTypes from "prop-types";
import DatePicker from "react-datepicker";
import { withTagDefaultProps } from "Hoc/Template";
import { formatDate as formatDateService } from "Services";
import "react-datepicker/dist/react-datepicker.css";

const propTypes = {
    onChange: PropTypes.func.isRequired,
    name: PropTypes.string.isRequired,
    placeholder: PropTypes.string,
    className: PropTypes.string,
    value: PropTypes.string,
    inputProps: PropTypes.objectOf(PropTypes.any),
};

const defaultProps = {
    placeholder: "",
    inputProps: {},
    className: '',
    value: '',
};

const toDateFormat = (str) => {
    if (str) {
        const timeArr = str.split(":");
        const date = new Date();
        date.setHours(timeArr[0]);
        date.setMinutes(timeArr[1]);
        return date;
    }
    return str;
};

const Time = ({ value, onChange, placeholder, pref, inputProps, className, name }) => {
    const _onChange = (_value) => {
        const requestValue = formatDateService(_value, "HH:mm", false);
        onChange({ target: { value: requestValue } });
    };

    const clearInput = () => {
        onChange({ target: { value: "" } });
    };

    // eslint-disable-next-line react/prop-types,no-shadow
    const CustomInput = forwardRef(({ value, onClick }, ref) => (
        <div className="main-timepicker__wrapper">
            <input {...inputProps} className={className} onClick={onClick} ref={ref} value={value} placeholder={placeholder} readOnly onChange={() => {}} />

            {value && (
                <div
                    className={`main-timepicker__close main-timepicker__close_${pref}`}
                    onKeyDown={clearInput}
                    onClick={clearInput}
                >
                    {" "}
                    x
                </div>
            )}
        </div>
    ));

    return (
        <DatePicker
            id={name}
            name={name}
            selected={toDateFormat(value)}
            onChange={_onChange}
            customInput={<CustomInput />}
            timeIntervals={1}
            timeFormat="HH:mm"
            dateFormat="HH:mm"
            showTimeSelect
            showTimeSelectOnly
        />
    );
};

Time.propTypes = propTypes;
Time.defaultProps = defaultProps;

export default withTagDefaultProps(Time);
