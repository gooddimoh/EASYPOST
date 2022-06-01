import React from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { url as _url } from 'Services';
import { TopTitleWrap } from 'Templates/Title';
import { ask } from 'Widgets/Modal';
import { InfoAddressBooksRecipient } from 'InfoManual';
import { DefaultButtonLink } from 'Templates/Link';
import { IconButton } from 'Templates/Button';
import TableView from '../../TableView';

const propTypes = {
    t: PropTypes.func.isRequired,
    service: PropTypes.shape({
        deleteItem: PropTypes.func.isRequired,
        url: PropTypes.string.isRequired,
    }).isRequired,
    forceFetch: PropTypes.func.isRequired,
};

const SenderTab = ({ t, forceFetch, service: { deleteItem, url } }) => {
    const buttons = [
        <IconButton
            key="edit-recipient"
            title="Edit recipient"
            icon="icon_edit"
            onClick={({ id }) => _url.redirect(`/${url}/${id}/edit`)}
        />,
        <IconButton
            key="delete-recipient"
            title="Delete recipient"
            icon="icon_delete"
            onClick={({ id }) => {
                ask('Do you want to delete the item?', async () => {
                    await deleteItem(`/${url}/${id}/delete`);
                    forceFetch();
                });
            }}
        />,
    ];

    return (
        <>
            <TopTitleWrap title="All recipients" info={<InfoAddressBooksRecipient />}>
                <DefaultButtonLink src={`/${url}/recipient`}>{t('Add recipient')}</DefaultButtonLink>
            </TopTitleWrap>
            <TableView buttons={buttons} />
        </>
    );
};

SenderTab.propTypes = propTypes;

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;

    return {
        forceFetch: getActionStore('forceFetch'),
    };
};

export default compose(withTagDefaultProps, connect(null, mapDispatchToProps))(SenderTab);
