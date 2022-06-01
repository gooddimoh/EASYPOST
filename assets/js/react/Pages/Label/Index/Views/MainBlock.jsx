import React, { lazy, Suspense } from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { ServiceProvider } from 'Services/Context';
import { InfoLabels } from 'InfoManual';
import { TopTitleWrap } from 'Templates/Title';
import { DefaultButtonLink } from 'Templates/Link';
import { ButtonsWrap } from 'Templates/Button';
import { Tabs, TabWrap } from 'Templates/Tabs';
import labelService from '../Services/Tabs/Label';
import draftService from '../Services/Tabs/Draft';

const LabelTab = lazy(() => import('./Tabs/LabelTab'));
const DraftTab = lazy(() => import('./Tabs/DraftTab'));

const propTypes = {
    activeTab: PropTypes.number.isRequired,
    onClickTab: PropTypes.func.isRequired,
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
    }).isRequired,
};

const MainBlock = ({ activeTab, onClickTab, service, t }) => {
    const { url } = service;

    return (
        <>
            <TopTitleWrap title="Labels list" info={<InfoLabels />}>
                <ButtonsWrap>
                    <DefaultButtonLink src={`/${url}/create-world`}>{t('Create World Label')}</DefaultButtonLink>
                    <DefaultButtonLink src={`/${url}/create-local`}>{t('Create Domestic US Label')}</DefaultButtonLink>
                </ButtonsWrap>
            </TopTitleWrap>

            <Tabs activeTab={activeTab} onClick={onClickTab}>
                <TabWrap label="Buyed labels">
                    <Suspense fallback={<div />}>
                        <ServiceProvider value={labelService}>
                            <LabelTab />
                        </ServiceProvider>
                    </Suspense>
                </TabWrap>
                <TabWrap label="Draft labels">
                    <Suspense fallback={<div />}>
                        <ServiceProvider value={draftService}>
                            <DraftTab />
                        </ServiceProvider>
                    </Suspense>
                </TabWrap>
            </Tabs>
        </>
    );
};

MainBlock.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => ({
    activeTab: getStoreItem(state, 'activeTab', 0),
});

const mapDispatchToProps = ({ service: { getActionStore } }) => ({
    onClickTab: getActionStore('onClickTab'),
});

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(MainBlock);
