import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { ServiceProvider } from 'Services/Context';
import { PageTitle } from 'Templates/Title';
import Income from './Cards/Income';
import Credit from './Cards/Credit';
import Registration from './Cards/Registration';
import Label from './Cards/Label';
import StatisticLabel from './Cards/StatisticLabel';
import Carrier from './Cards/Carrier';
import incomeService from '../Services/Income';
import creditService from '../Services/Credit';
import registrationService from '../Services/Registration';
import labelService from '../Services/Label';
import carrierService from '../Services/Carrier';
import statisticLabelService from '../Services/StatisticLabel';

const propTypes = {
    pref: PropTypes.string.isRequired,
};

const MainBlock = ({ pref }) => {
    return (
        <div className={`statistics statistics_${pref}`}>
            <PageTitle title="Statistics" />
            <div className={`statistics__wrap statistics_wrap_${pref}`}>
                <ServiceProvider value={incomeService}>
                    <Income />
                </ServiceProvider>

                <ServiceProvider value={creditService}>
                    <Credit />
                </ServiceProvider>

                <ServiceProvider value={registrationService}>
                    <Registration />
                </ServiceProvider>

                <ServiceProvider value={labelService}>
                    <Label />
                </ServiceProvider>

                <ServiceProvider value={carrierService}>
                    <Carrier />
                </ServiceProvider>
            </div>
            <div className={`statistics__wrap statistics_wrap_${pref}`}>
                <ServiceProvider value={statisticLabelService}>
                    <StatisticLabel />
                </ServiceProvider>
            </div>
        </div>
    );
};

MainBlock.propTypes = propTypes;

export default withTagDefaultProps(MainBlock);
