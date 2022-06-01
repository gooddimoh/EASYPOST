import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import { ViewInfo, ViewInfoWrap, ViewInfoSidebar, ViewInfoContent } from 'Templates/ViewInfo';
import InfoWrap from './Views/InfoWrap';
import MainBlock from './Views/MainBlock';

const Index = () => {
    return (
        <ViewInfo>
            <ViewInfoWrap>
                <ViewInfoSidebar>
                    <InfoWrap />
                </ViewInfoSidebar>
                <ViewInfoContent>
                    <MainBlock />
                </ViewInfoContent>
            </ViewInfoWrap>
        </ViewInfo>
    );
};

export default withTagDefaultProps(Index);
