import React from 'react';
import connect from 'Hoc/Template/Connect';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { compose } from 'ramda';
import { url as _url } from 'Services';
import { ask } from 'Widgets/Modal';
import { TableWidget } from 'Widgets/Table';
import { IconButton } from 'Templates/Button';

const propTypes = {
    service: PropTypes.shape({
        deleteItem: PropTypes.func.isRequired,
    }).isRequired,
    forceFetch: PropTypes.func.isRequired,
};

const LabelTab = ({ service, forceFetch }) => {
    const { deleteItem } = service;

    const buttons = [
        <IconButton
            key="create-analog"
            title="Create analog"
            icon="icon_clone"
            onClick={({ id }) => _url.redirect(`/labels/${id}/clone`)}
        />,
        <IconButton
            key="edit-draft"
            title="Edit draft"
            icon="icon_edit"
            onClick={({ id }) => _url.redirect(`/labels/${id}/edit`)}
        />,
        <IconButton
            key="delete-draft"
            title="Delete draft"
            icon="icon_delete"
            onClick={({ id }) => {
                ask('Do you want to delete the item?', async () => {
                    await deleteItem(`/labels/${id}/delete`);
                    forceFetch();
                });
            }}
        />,
    ];

    return <TableWidget buttons={buttons} />;
};

LabelTab.propTypes = propTypes;

const mapDispatchToProps = ({ service: { getActionStore } }) => ({
    forceFetch: getActionStore('forceFetch'),
});

export default compose(withTagDefaultProps, connect(null, mapDispatchToProps))(LabelTab);
