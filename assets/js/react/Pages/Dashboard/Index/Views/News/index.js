import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import {Slider} from 'Templates/Slider';

const propTypes = {
    data: PropTypes.arrayOf(PropTypes.any).isRequired,
};

const News = ({ data }) => {
    return (
        <Slider data={data} />
    );
};

News.propTypes = propTypes;

export default withTagDefaultProps(News);
