import * as R from 'ramda';
import Select from 'react-select/async';

export default class AsyncMultiSelectReact extends Select {
    reload(nextProps) {
        this.loadOptions(
            '',
            (options) => {
                const isLoading = !!this.lastRequest;
                this.setState({ defaultOptions: options || [], isLoading }, () => {
                    R.pathOr(() => {}, ['onResetOptions'], nextProps)('');
                });
            },
            nextProps,
        );
    }

    loadOptions(inputValue, callback, props) {
        props = props || this.props;

        const { loadOptions } = props;

        if (!loadOptions) return callback();
        const loader = loadOptions(inputValue, callback);

        if (loader && typeof loader.then === 'function') {
            loader.then(callback, callback);
        }

        return null;
    }

    componentWillReceiveProps(nextProps) {
        if (nextProps.cacheOptions !== this.props.cacheOptions) {
            this.optionsCache = {};
        }

        if (JSON.stringify(nextProps.loadArguments) !== JSON.stringify(this.props.loadArguments)) {
            this.reload(nextProps);
        }

        if (nextProps.defaultOptions !== this.props.defaultOptions) {
            this.setState({
                defaultOptions: Array.isArray(nextProps.defaultOptions) ? nextProps.defaultOptions : undefined,
            });
        }
    }
}
