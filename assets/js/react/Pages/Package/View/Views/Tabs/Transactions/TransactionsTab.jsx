import React from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { ServiceProvider } from 'Services/Context';
import { ask } from "Widgets/Modal";
import { TabBox, TabBoxColumn } from 'Templates/Tabs';
import { IconButton } from 'Templates/Button';
import service from '../../../Services/Tabs/Transactions';
import TableView from '../../TableView';

const propTypes = {
    service: PropTypes.shape({
        deleteItem: PropTypes.func.isRequired,
        url: PropTypes.string.isRequired,
    }).isRequired,
    forceFetch: PropTypes.func.isRequired,
};

const TransactionTab = ({ forceFetch }) => {
    const { url, deleteItem } = service;

    const buttons = [
        <IconButton
            key="delete-transaction"
            title="Delete transaction"
            icon="icon_delete"
            onClick={({ id }) => {
                ask('Do you want to delete the item?',
                    async () => {
                        await deleteItem(`/${url}/${id}/delete`);
                        forceFetch();
                    });
            }}
        />,
    ];

    return (
        <ServiceProvider value={service}>
            <TabBox>
                <TabBoxColumn>
                    <div className="tab-box__title">total:</div>
                </TabBoxColumn>
            </TabBox>
            <TableView buttons={buttons}/>
        </ServiceProvider>
    );
};

TransactionTab.propTypes = propTypes;

const mapDispatchToProps = () => {
    const { getActionStore } = service;
    return {
        forceFetch: getActionStore('forceFetch'),
    };
};

export default compose(withTagDefaultProps, connect(null, mapDispatchToProps))(TransactionTab);
