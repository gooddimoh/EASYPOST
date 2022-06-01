import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';

const InfoUsers = ({ t }) => {
    return (
        <div className="info-manual__text">
            {t(
                'Don’t miss out on the chance to scale up your business. By delegating relevant activities to the appropriate level, you will be able to bolster your company’s efficiency and streamline standard procedures. Now you can grant access to your account to all your colleagues and employees. You can always add new users to your account by clicking the button “Add user” in the top right corner of the screen. Just type in all required information and press the “Save” button to save the data.',
            )}
        </div>
    );
};

export default withTagDefaultProps(InfoUsers);
