import React, { Component } from "react";
import * as R from 'ramda';
import PropTypes from "prop-types";
import { withTagDefaultProps } from 'Hoc/Template';
import { url as urlService, request } from "Services";
import AsyncMultiSelectReact from "./AsyncMultiSelectReact";

const propTypes = {
    disabled: PropTypes.bool,
    placeholder: PropTypes.string,
    name: PropTypes.string.isRequired,
    handleChange: PropTypes.func,
    value: PropTypes.oneOfType([
        PropTypes.string,
        PropTypes.arrayOf(PropTypes.oneOfType([PropTypes.string, PropTypes.object])),
    ]).isRequired,
    inputProps: PropTypes.shape({
        isOptionDisabled: PropTypes.func,
        url: PropTypes.string,
    }),
    url: PropTypes.string.isRequired,
    t: PropTypes.func.isRequired
};

const defaultProps = {
    disabled: false,
    placeholder: "Search",
    inputProps: {
        isOptionDisabled: (option) => option.disable,
        url: "",
    },
    handleChange: () => {},
};

class AsyncMultiSelect extends Component {
    state = {
        value: false,
    };

    componentDidMount = () => {
        this.setValue();
    };

    handleChange = (selectedOption) => {
        this.setState(
            {
                value: selectedOption,
            },
            () => {
                const { handleChange } = this.props;
                handleChange(selectedOption ? selectedOption.map((v) => v.value) : "");
            },
        );
    };

    getOptions = (url) => (data) => {
        if (url.includes("//")) {
            return new Promise((resolve) => resolve([]));
        }

        return new Promise((resolve, reject) => {
            request
                .sendRequest(
                    {
                        url: urlService.getUrl(url),
                        data,
                        type: "GET",
                    },
                    false,
                )
                .then((res) => {
                    const options = R.pathOr([], [0, 'items'], res);
                    resolve(options);
                }, reject);
        });
    };

    setValue = () => {
        const { url, value } = this.props;
        if (value && !url.includes("//")) {
            this.getOptions(`${url}/${value}`)({}).then((options) => {
                this.setState({
                    value: R.head(options) || {},
                });
            });
        }
    };

    render = () => {
        const { value } = this.state;
        const { inputProps: { url }, disabled, inputProps, placeholder, name, t } = this.props;

        const customStyles = {
            control: (base) => ({
                ...base,
            }),
        };

        const loadOptions = this.getOptions(url);

        return (
            <AsyncMultiSelectReact
                id={name}
                name={name}
                isMulti
                isLoading
                menuPosition="fixed"
                closeMenuOnScroll={(e) => !e.target.parentNode.className.includes("menu")}
                placeholder={t(placeholder)}
                isDisabled={disabled}
                inputProps={inputProps}
                styles={customStyles}
                loadArguments={{ url }}
                value={t(value)}
                className="select-custom-wrap basic-multi-select custom-select"
                classNamePrefix="custom-select"
                cacheOptions
                defaultOptions
                isClearable={false}
                onChange={this.handleChange}
                onResetOptions={this.handleChange}
                loadOptions={(label) => loadOptions({ label })}
            />
        );
    };
}

AsyncMultiSelect.propTypes = propTypes;
AsyncMultiSelect.defaultProps = defaultProps;

export default withTagDefaultProps(AsyncMultiSelect);
