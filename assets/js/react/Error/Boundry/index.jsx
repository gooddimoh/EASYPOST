import React, {Component} from "react";
import ErrorIndicator from "../Indicator";

class ErrorBoundary extends Component {

    state = {
        hasError: false
    };

    componentDidCatch(error, errorInfo) {
        this.setState({
            hasError: true,
            error,
            errorInfo
        });
    }

    render() {
        if (this.state.hasError) {
            return (<ErrorIndicator error={this.state.error} errorInfo={this.state.errorInfo}/>);
        }

        return this.props.children;
    }
}

export default ErrorBoundary;
