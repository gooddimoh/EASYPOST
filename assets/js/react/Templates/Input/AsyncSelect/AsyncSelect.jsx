import React, { useEffect, useState } from 'react';
import * as R from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { url as urlService, request } from 'Services';
import AsyncSelectReact from './AsyncSelectReact';

const propTypes = {
    disabled: PropTypes.bool,
    placeholder: PropTypes.string,
    name: PropTypes.string.isRequired,
    handleChange: PropTypes.func,
    value: PropTypes.string.isRequired,
    inputProps: PropTypes.shape({
        isOptionDisabled: PropTypes.func,
        url: PropTypes.string,
    }),
    t: PropTypes.func.isRequired,
};

const defaultProps = {
    disabled: false,
    placeholder: 'Search',
    inputProps: { isOptionDisabled: (option) => option.disable, url: '' },
    handleChange: () => {},
};

const AsyncSelect = ({ disabled, placeholder, name, handleChange, value, inputProps, t }) => {
    const { url } = inputProps;
    const [state, setState] = useState({ value: false });

    const getOptions = (_url) => (data) => {
        if (url.includes('//')) return new Promise((resolve) => resolve([]));
        return new Promise((resolve, reject) => {
            request
                .sendRequest(
                    {
                        url: urlService.getUrl(_url),
                        data,
                        type: 'GET',
                    },
                    false,
                )
                .then((res) => {
                    resolve(res[0].items);
                }, reject);
        });
    };

    const setValue = async (_value) => {
        if (value && value !== state.value && !url.includes('//')) {
            const options = await getOptions(url)({ id: _value });
            setState({ value: R.head(options) || {} });
        }
        if (!value) {
            setState({ value });
        }
    };

    const _handleChange = (selectedOption) => {
        setState({ value: selectedOption });
        handleChange(selectedOption || '');
    };

    const customStyles = {
        control: (base) => ({
            ...base,
        }),
    };

    const loadOptions = getOptions(url);

    useEffect(() => {
        setValue(value);
    }, [value]);

    return (
        <AsyncSelectReact
            isLoading={false} // Need global fix for async select own wrap
            id={name}
            name={name}
            menuPosition="fixed"
            className="custom-select"
            classNamePrefix="custom-select"
            closeMenuOnScroll={(e) => {
                const parent = e.target.parentNode;
                return parent ? !parent.className.includes('menu') : true;
            }}
            placeholder={t(placeholder)}
            isDisabled={disabled}
            inputProps={inputProps}
            styles={customStyles}
            loadArguments={{ url }}
            value={state.value}
            cacheOptions
            defaultOptions
            onChange={_handleChange}
            isClearable
            onResetOptions={_handleChange}
            loadOptions={(label) => loadOptions({ label })}
        />
    );
};

AsyncSelect.propTypes = propTypes;
AsyncSelect.defaultProps = defaultProps;

export default withTagDefaultProps(AsyncSelect);
