import Chart from 'chart.js/auto';
import { mergeDeepLeft } from 'ramda';
import { randomColor } from 'Services';

const colors = ['#4918cd', '#a721ff', '#28B446', '#f03738'];

export const getLabels = (data) => Object.keys(data);
export const getData = (data, options) => {
    const dataItems = [];

    Object.values(data).forEach(({ items }) => {
        items.forEach((item, index) => {
            const itemColor = colors[index] || randomColor();
            const eachItem = dataItems[index] || {
                label: item.name,
                data: [],
                backgroundColor: itemColor,
                borderColor: itemColor,
                pointBackgroundColor: itemColor,
                ...(options || {}),
            };

            eachItem.data = [...eachItem.data, Number(item.value)];
            dataItems[index] = eachItem;
        });
    });

    return {
        labels: getLabels(data),
        datasets: Object.values(dataItems),
    };
};

const NewChart = (ref, type, data = {}, options = {}) => {
    const _data = {
        labels: [],
        datasets: [
            {
                label: '',
                data: [],
            },
        ],
    };

    const _options = {
        devicePixelRatio: 1,
        responsive: false,
        maintainAspectRatio: false,
        layout: {
            padding: {
                right: 0,
                left: 0,
                top: 0,
                bottom: 0,
            },
        },
        plugins: {
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true,
                },
            },
        },
        elements: {
            line: {
                borderWidth: 1,
            },
            point: {
                radius: 6,
                hitRadius: 10,
                hoverRadius: 6,
            },
        },
    };

    return new Chart(ref, {
        type,
        data: mergeDeepLeft(_data, data),
        options: mergeDeepLeft(_options, options),
    });
};

export default NewChart;
