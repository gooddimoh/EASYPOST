import React, { Component } from 'react';
import PropTypes from 'prop-types';
import NewChart, { /* getLabels , */ getData } from 'Templates/Chart/NewChart';
import ResizeDetector from 'Hoc/Template/ResizeDetector';

const propTypes = {
    data: PropTypes.objectOf(PropTypes.any),
    type: PropTypes.string,
    dataOptions: PropTypes.objectOf(PropTypes.any),
    options: PropTypes.objectOf(PropTypes.any),
};

const defaultProps = {
    type: 'line',
    data: {},
    dataOptions: {},
    options: {},
};

class ChartWrapper extends Component {
    state = {
        width: 0,
        height: 0,
    };

    myChart = {};

    chartRef = React.createRef();

    componentDidMount() {
        const { type, data, dataOptions, options } = this.props;
        const _chartRef = this.chartRef.current.getContext('2d');

        this.myChart = NewChart(_chartRef, type, dataOptions, options);
        this.pushData(data, dataOptions);
    }

    shouldComponentUpdate(nextProps) {
        const { data, dataOptions } = nextProps;

        if (JSON.stringify(data) !== JSON.stringify(this.props.data)) {
            this.pushData(data, dataOptions);
        }

        return true;
    }

    onResize = async (width, height) => {
        this.setState(
            {
                width,
                height,
            },
            () => {
                this.myChart.width = width;
                this.myChart.height = height;
                this.myChart.update();
            },
        );
    };

    pushData(data, dataOptions) {
        this.myChart.data = getData(data, dataOptions);
        // this.myChart.options.scales.xAxes[0].labels = getLabels(data); // Todo: fix this line
        this.myChart.update();
    }

    render() {
        const { width, height } = this.state;

        return (
            <ResizeDetector onResize={this.onResize} onInitSize={this.onResize}>
                <div style={{ width }}>
                    <canvas {...{ width, height }} style={{ width, height }} ref={this.chartRef} />
                </div>
            </ResizeDetector>
        );
    }
}

ChartWrapper.propTypes = propTypes;
ChartWrapper.defaultProps = defaultProps;

export default ChartWrapper;
