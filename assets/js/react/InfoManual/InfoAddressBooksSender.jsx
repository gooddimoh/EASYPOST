import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';

const InfoAddressBooksSender = ({ t }) => {
    return (
        <div className="info-manual__text">
            {t(
                'Run your business as expeditiously and effectively as possible. Now you can manage your both sender and recipient lists and keep them continuously up to date.While expanding your professional contacts, click the “Add company” button, fill in the blanks and press the “Save” button. An updated list of your contacts will help you stay on top of everyday challenges.',
            )}
        </div>
    );
};

export default withTagDefaultProps(InfoAddressBooksSender);
