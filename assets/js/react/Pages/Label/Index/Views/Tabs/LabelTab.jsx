import React from 'react';
import connect from 'Hoc/Template/Connect';
import PropTypes from 'prop-types';
import { withTagDefaultProps, PermissionsProps } from 'Hoc/Template';
import { compose } from 'ramda';
import { url as _url } from 'Services';
import { IconButton } from 'Templates/Button';
import { showModal } from 'Widgets/Modal';
import { TableWidget } from 'Widgets/Table';
import LabelModal from 'App/View/Modal/Label';
import { permissionsEnum } from 'Services/Enums';

const propTypes = {
    getLabelInfo: PropTypes.func.isRequired,
    clearLabelState: PropTypes.func.isRequired,
    isGranted: PropTypes.func.isRequired,
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
        check20dayTerms: PropTypes.func.isRequired,
    }).isRequired,
};

const LabelTab = ({ service, getLabelInfo, isGranted, clearLabelState }) => {
    const { url, check20dayTerms } = service;

    const showPickupModal = async (id) => {
        const res = await getLabelInfo(id);
        if (res) {
            showModal(<LabelModal />, clearLabelState);
        }
    };

    const buttons = [
        <IconButton
            key="create-analog"
            title="Create analog"
            icon="icon_clone"
            onClick={({ id }) => _url.redirect(`/${url}/${id}/clone`)}
        />,
        <IconButton
            key="Get-label"
            title="Get label"
            icon="icon_get_label"
            onClick={({ label_url }) => window.open(label_url, '_blank')}
        />,
        <IconButton
            key="Pickup"
            title="Pickup"
            icon="icon_delivery"
            show={check20dayTerms}
            isShow={(item) => isGranted(permissionsEnum.pickup) && +item.need_pickup && !item.pickup_id}
            onClick={({ id }) => showPickupModal(id)}
        />,
    ];

    return <TableWidget buttons={buttons} />;
};

LabelTab.propTypes = propTypes;

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        getLabelInfo: getActionStore('getLabelInfo'),
        clearLabelState: getActionStore('clearLabelState'),
    };
};

export default compose(withTagDefaultProps, connect(null, mapDispatchToProps), PermissionsProps)(LabelTab);
