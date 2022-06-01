import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import { AsideInfo, AsideLogo, AsideTitle } from 'Templates/ViewInfo';
import { AsideWidget } from 'Widgets/AsideWidget';

const InfoWrap = ({ service: { url } }) => {
    const backUrl = `/${ url }`;
    const editUrl = (id) => `/${ url }/${ id }/edit`;

    const configView = [
        (item) => <AsideLogo img={ item.photo }/>,
        (item) => <AsideTitle title={ `${ item.name }` }/>,
        (item) => <AsideInfo title='Company name' value={ item.name }/>,
    ];

    return <AsideWidget config={ configView } backUrl={ backUrl } editUrl={ editUrl }/>;
};

export default withTagDefaultProps(InfoWrap);
