import React, { Fragment } from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';

const propTypes = {
    sender: PropTypes.objectOf(PropTypes.any).isRequired,
    recipient: PropTypes.objectOf(PropTypes.any).isRequired,
    service: PropTypes.shape({
        tableLabel: PropTypes.objectOf(PropTypes.string).isRequired,
        getTableRow: PropTypes.func.isRequired,
    }).isRequired,
};

const MainBlock = ({ sender, recipient, service, t }) => {
    const { tableLabel, getTableRow } = service;

    return (
        <div className="label-cards">
            <div className="label-cards__item">
                <div className="card">
                    <div className="card__title">{t('Sender')}</div>
                    <div className="card-table">
                        {Object.keys(tableLabel).map((item, k) => (
                            <Fragment key={`SenderRow-${k}`}>{getTableRow(item, sender)}</Fragment>
                        ))}
                    </div>
                </div>
            </div>
            <div className="label-cards__item">
                <div className="card">
                    <div className="card__title">{t('Recipient')}</div>
                    <div className="card-table">
                        {Object.keys(tableLabel).map((item, k) => (
                            <Fragment key={`RecipientRow-${k}`}>{getTableRow(item, recipient)}</Fragment>
                        ))}
                    </div>
                </div>
            </div>
        </div>
    );
};

MainBlock.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        sender: getStoreItem(state, ['view', 'sender'], {}),
        recipient: getStoreItem(state, ['view', 'recipient'], {}),
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        onClickTab: getActionStore('onClickTab'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(MainBlock);
