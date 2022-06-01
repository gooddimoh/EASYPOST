import React, { memo } from 'react';
import * as R from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import AsyncSelect from 'Templates/Input/AsyncSelect/AsyncSelect';
import AsyncMultiSelect from 'Templates/Input/AsyncMultiSelect/AsyncMultiSelect';
import DateInputWrap from './DateTime/DateInputWrap';
import TimeWrap from './DateTime/TimeWrap';
import DateTimeWrap from './DateTime/DateTimeWrap';
import TextArea from './TextArea';
import Select from './Select';
import MultiSelect from './MultiSelect';
import ToggleCheckbox from './ToggleCheckbox';
import DefaultInput from './DefaultInput';
import DateRangeInputWrap from './DateTime/DateRangeInputWrap';
import MagnifyGlassWrap from './MagnifyGlassWrap';
import PasswordWrap from './PasswordWrap';
import Checkbox from './Checkbox';
import Radio from './Radio';

const propTypes = {
    disabled: PropTypes.bool,
    type: PropTypes.string,
    name: PropTypes.string.isRequired,
    value: PropTypes.oneOfType([PropTypes.string, PropTypes.arrayOf(PropTypes.string)]),
    onChange: PropTypes.func,
    placeholder: PropTypes.string,
    inputProps: PropTypes.objectOf(PropTypes.any),
    dayPickerProps: PropTypes.objectOf(PropTypes.any),
    checked: PropTypes.bool,
};

const defaultProps = {
    disabled: false,
    type: 'text',
    onChange: () => {},
    placeholder: '',
    value: '',
    checked: false,
    inputProps: {},
    dayPickerProps: {},
};

const Input = ({ disabled, name, type, placeholder, value, inputProps, onChange, checked, dayPickerProps, pref }) => {
    const _onChange = (e) => {
        const _value = R.pathOr(R.pathOr(e, ['value'], e), ['target', 'value'], e);
        onChange(_value);
    };

    const className = `input input_${pref} ${inputProps.className ? inputProps.className : ''}`;

    switch (type) {
        case 'asyncSelect':
            return (
                <AsyncSelect
                    name={name}
                    placeholder={placeholder}
                    disabled={disabled}
                    inputProps={inputProps}
                    value={value}
                    handleChange={_onChange}
                    className={className}
                />
            );

        case 'searchSelect':
            return (
                <Select
                    name={name}
                    isSearchable
                    disabled={disabled}
                    inputProps={inputProps}
                    value={value}
                    placeholder={placeholder}
                    onChange={_onChange}
                    className={className}
                />
            );

        case 'select':
            return (
                <Select
                    name={name}
                    disabled={disabled}
                    inputProps={inputProps}
                    value={value}
                    placeholder={placeholder}
                    onChange={_onChange}
                    className={className}
                />
            );

        case 'multiSelect':
            return (
                <MultiSelect
                    name={name}
                    disabled={disabled}
                    inputProps={inputProps}
                    placeholder={placeholder}
                    onChange={_onChange}
                    className={className}
                />
            );
        case 'asyncMultiSelect':
            return (
                <AsyncMultiSelect
                    id={name}
                    name={name}
                    placeholder={placeholder}
                    inputProps={{ ...inputProps, className }}
                    value={value}
                    handleChange={_onChange}
                    className={className}
                />
            );

        case 'textarea':
            return (
                <TextArea
                    name={name}
                    placeholder={placeholder}
                    value={value}
                    onChange={_onChange}
                    inputProps={{ ...inputProps, className }}
                />
            );

        case 'date':
            return (
                <DateInputWrap
                    name={name}
                    placeholder={placeholder}
                    value={value}
                    onChange={_onChange}
                    inputProps={inputProps}
                    className={className}
                />
            );

        case 'time':
            return (
                <TimeWrap
                    name={name}
                    placeholder={placeholder}
                    value={value}
                    onChange={_onChange}
                    inputProps={inputProps}
                    className={className}
                />
            );

        case 'dateTime':
            return (
                <DateTimeWrap
                    name={name}
                    placeholder={placeholder}
                    value={value}
                    onChange={_onChange}
                    inputProps={inputProps}
                    className={className}
                />
            );

        case 'dateRange':
            return (
                <DateRangeInputWrap
                    {...inputProps}
                    name={name}
                    placeholder={placeholder}
                    value={value}
                    onChange={_onChange}
                    inputProps={inputProps}
                    className={className}
                    dayPickerProps={dayPickerProps}
                />
            );

        case 'magnifyGlass':
            return (
                <MagnifyGlassWrap
                    {...inputProps}
                    id={name}
                    name={name}
                    disabled={disabled}
                    placeholder={placeholder}
                    value={value}
                    onChange={_onChange}
                    className={className}
                />
            );

        case 'toggleCheckbox':
            return (
                <ToggleCheckbox
                    id={name}
                    name={name}
                    value={value}
                    checked={checked}
                    disabled={disabled}
                    onChange={_onChange}
                    inputProps={inputProps}
                />
            );

        case 'checkbox':
            return (
                <Checkbox
                    id={name}
                    name={name}
                    value={value}
                    checked={checked}
                    disabled={disabled}
                    onChange={_onChange}
                    inputProps={inputProps}
                />
            );

        case 'radio':
            return (
                <Radio
                    id={name}
                    name={name}
                    value={value}
                    checked={checked}
                    disabled={disabled}
                    onChange={_onChange}
                    inputProps={inputProps}
                />
            );

        case 'password':
            return (
                <PasswordWrap
                    {...inputProps}
                    id={name}
                    name={name}
                    disabled={disabled}
                    placeholder={placeholder}
                    value={value}
                    onChange={_onChange}
                    className={className}
                />
            );

        default:
            return (
                <DefaultInput
                    id={name}
                    name={name}
                    type={type}
                    disabled={disabled}
                    placeholder={placeholder}
                    value={value}
                    onChange={_onChange}
                    className={className}
                    inputProps={inputProps}
                />
            );
    }
};

Input.propTypes = propTypes;
Input.defaultProps = defaultProps;

export default R.compose(memo, withTagDefaultProps)(Input);
