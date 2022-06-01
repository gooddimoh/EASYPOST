import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import { AsideInfo } from 'Templates/ViewInfo';
import { AsideWidget } from 'Widgets/AsideWidget';

const InfoWrap = ({ service: { url } }) => {
    const backUrl = `/${url}`;

    const configView = [
        (item) => <AsideInfo title="Service" value={item.service} />,
        (item) => <AsideInfo title="Track" value={item.track} />,
        (item) => <AsideInfo title="Rate" value={item.rate} />,
    ];

    return <AsideWidget config={configView} backUrl={backUrl} />;
};

export default withTagDefaultProps(InfoWrap);
