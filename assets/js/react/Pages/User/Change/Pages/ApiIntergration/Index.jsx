import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { PageTitle, BackLink } from 'Templates/Title';

const propTypes = {
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
    }).isRequired,
};

const ApiIntegration = ({ service: { url } }) => {

    return (
        <div className="main-content__block">
            <PageTitle title="Api Integration" before={<BackLink url={`/${url}`} />} />
        </div>
    );
};

ApiIntegration.propTypes = propTypes;

export default withTagDefaultProps(ApiIntegration);
