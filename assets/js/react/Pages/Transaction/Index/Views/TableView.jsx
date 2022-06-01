import React from 'react';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import PropTypes from 'prop-types';
import { withTagDefaultProps, CheckPermission } from 'Hoc/Template';
import { url as _url } from 'Services';
import { InfoTransactions } from 'InfoManual';
import { TableWidget } from 'Widgets/Table';
import { TopTitleWrap } from 'Templates/Title';
import { ButtonsWrap } from 'Templates/Button';
import { DefaultButtonLink } from 'Templates/Link';

const propTypes = {
    t: PropTypes.func.isRequired,
    request: PropTypes.objectOf(PropTypes.any).isRequired,
    service: PropTypes.shape({
        url: PropTypes.string.isRequired,
    }).isRequired,
};

const TableView = ({ t, service, request }) => {
    const { url } = service;

    return (
        <>
            <TopTitleWrap title="Transactions" info={<InfoTransactions />}>
                <ButtonsWrap>
                    <CheckPermission>
                        <DefaultButtonLink src={`/${url}/create`}>{t('Add transaction')}</DefaultButtonLink>
                    </CheckPermission>
                    <DefaultButtonLink src={_url.getUrl(`/${url}/export`, request, '')}>
                        {t('Export transaction')}
                    </DefaultButtonLink>
                </ButtonsWrap>
            </TopTitleWrap>

            <TableWidget />
        </>
    );
};

TableView.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        request: {
            filter: getStoreItem(state, 'filter', {}),
            sort: getStoreItem(state, 'sort', {}),
        },
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps))(TableView);
