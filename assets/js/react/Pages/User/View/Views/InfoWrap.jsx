import React from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps, PermissionsProps } from 'Hoc/Template';
import { AsideTitle, AsideLogo, AsideInfo } from 'Templates/ViewInfo';
import { AsideWidget } from 'Widgets/AsideWidget';
import { roleOptions, permissionsEnum } from 'Services/Enums';
import { url as _url } from 'Services';
import { IconButton } from 'Templates/Button';
import { ImageLink } from 'Templates/Link';

const propTypes = {
    userId: PropTypes.string.isRequired,
    companyId: PropTypes.string.isRequired,
    companyName: PropTypes.string.isRequired,
    isGranted: PropTypes.func.isRequired,
    isMe: PropTypes.func.isRequired,
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
    }).isRequired,
};

const InfoWrap = ({ userId, companyId, companyName, isGranted, isMe, service: { url } }) => {
    const backUrl = `/${url}`;
    const editUrl =
        isGranted(permissionsEnum.owner, companyId) || isMe(userId) ? (id) => `/${url}/${id}/edit` : undefined;

    const configView = [
        (item) => <AsideLogo img={item.photo} />,
        () =>
            isMe(userId) && <ImageLink title="Export my data" src={_url.getUrl(`/${url}/export/my-profile`, '', '')} />,
        (item) => <AsideTitle title={item.name} />,
        (item) => <AsideInfo type="email" value={item.email} title="Email" />,
        (item) => <AsideInfo type="enum" value={item.role} title="Role" options={roleOptions} />,
        () =>
            isGranted(permissionsEnum.owner, companyId) ? (
                <AsideInfo
                    type="link"
                    value={companyName}
                    title="Company"
                    options={{ href: `${window.location.origin}/companies/${companyId}` }}
                >
                    <IconButton
                        key="edit-company"
                        title="Edit company"
                        icon="icon_edit"
                        onClick={() => _url.redirect(`/companies/${companyId}/edit`)}
                    />
                </AsideInfo>
            ) : (
                <AsideInfo title="Company" value={companyName} />
            ),
    ];

    return <AsideWidget config={configView} backUrl={backUrl} editUrl={editUrl} />;
};

InfoWrap.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        userId: getStoreItem(state, ['view', 'id'], ''),
        companyId: getStoreItem(state, ['view', 'company', 'id'], ''),
        companyName: getStoreItem(state, ['view', 'company', 'name'], ''),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps), PermissionsProps)(InfoWrap);
