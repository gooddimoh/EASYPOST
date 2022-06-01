import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import PropTypes from 'prop-types';
import Header from './Header';
import Body from './Body';
import Footer from './Footer';

const propTypes = {
    title: PropTypes.string.isRequired,
    type: PropTypes.string.isRequired,
    editable: PropTypes.bool.isRequired,
    text: PropTypes.string.isRequired,
    flagLabel: PropTypes.bool.isRequired,
    onClickEdit: PropTypes.func.isRequired,
    onClickDelete: PropTypes.func.isRequired,
};

const CarrierCard = ({ title, editable, type, text, flagLabel, onClickEdit, pref, onClickDelete }) => {
    return (
        <div className={`carrier-card carrier-card_${pref}`}>
            <Header type={type} flagLabel={flagLabel} />
            <Body title={title} text={text} />
            <Footer
                onClickEdit={onClickEdit}
                flagLabel={flagLabel}
                onClickDelete={onClickDelete}
                editable={editable}
                type={type}
            />
        </div>
    );
};

CarrierCard.propTypes = propTypes;

export default withTagDefaultProps(CarrierCard);
