import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import PropTypes from 'prop-types';
import { BorderButton } from 'Templates/Button';

const propTypes = {
    onClickEdit: PropTypes.func.isRequired,
    onClickDelete: PropTypes.func.isRequired,
    flagLabel: PropTypes.bool.isRequired,
    editable: PropTypes.bool.isRequired,
    t: PropTypes.func.isRequired,
};

const Footer = ({ onClickEdit, flagLabel, editable, onClickDelete, t, pref }) => {
    return (
        <div className={`carrier-card__footer carrier-card__footer_${pref}`}>
            {flagLabel && (
                <BorderButton fullWidth name="delete" onClick={onClickDelete}>
                    {t('Delete')}
                </BorderButton>
            )}
            {editable && (
                <BorderButton fullWidth name="edit" onClick={onClickEdit}>
                    {t('Edit')}
                </BorderButton>
            )}
        </div>
    );
};

Footer.propTypes = propTypes;

export default withTagDefaultProps(Footer);
