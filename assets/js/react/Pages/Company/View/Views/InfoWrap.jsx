import React from 'react';
import PropTypes from "prop-types";
import connect from "Hoc/Template/Connect";
import { compose } from "ramda";
import { withTagDefaultProps, PermissionsProps } from 'Hoc/Template';
import { permissionsEnum } from 'Services/Enums';
import { AsideInfo, AsideLogo, AsideTitle } from 'Templates/ViewInfo';
import { AsideWidget } from 'Widgets/AsideWidget';

const propTypes = {
    companyId: PropTypes.string.isRequired,
    isGranted: PropTypes.func.isRequired,
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
    }).isRequired,
};

const InfoWrap = ({ isGranted, companyId, service: { url } }) => {
    const backUrl = `/${ url }`;

    const editUrl = (isGranted(permissionsEnum.owner, companyId))
                        ? (id) => `/${ url }/${ id }/edit`
                        : undefined;

    const configView = [
        (item) => <AsideLogo img={ item.photo }/>,
        (item) => <AsideTitle title={ `${ item.name }` }/>,
        (item) => <AsideInfo title='Company name' value={ item.name }/>,
    ];

    return <AsideWidget config={ configView } backUrl={ backUrl } editUrl={ editUrl }/>;
};

InfoWrap.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        companyId: getStoreItem(state, ['view', 'id'], ''),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps), PermissionsProps)(InfoWrap);
