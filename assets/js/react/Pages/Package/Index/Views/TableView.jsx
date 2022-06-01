import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { TableWidget } from 'Widgets/Table';
import { InfoPackage } from 'InfoManual';
import { TopTitleWrap } from 'Templates/Title';
import { DefaultButtonLink } from 'Templates/Link';
import { IconButton } from 'Templates/Button';
import { url as _url } from 'Services';

const propTypes = {
    t: PropTypes.func.isRequired,
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
    }).isRequired,
};

const TableView = ({ t, service }) => {
    const { url } = service;

    const buttons = [
        <IconButton
            key="edit"
            title="Edit"
            icon="icon_edit"
            onClick={({ id }) => _url.redirect(`/${url}/${id}/edit`)}
        />,
    ];

    return (
        <>
            <TopTitleWrap title="Packages" info={<InfoPackage />}>
                <DefaultButtonLink src={`/${url}/create`}>{t('Add package')}</DefaultButtonLink>
            </TopTitleWrap>
            <TableWidget buttons={buttons} />
        </>
    );
};

TableView.propTypes = propTypes;

export default withTagDefaultProps(TableView);
