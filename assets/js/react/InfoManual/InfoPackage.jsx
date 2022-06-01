import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';

const InfoPackage = ({ t }) => {
    return <div className="info-manual__text">{t('Package Info')}</div>;
};

export default withTagDefaultProps(InfoPackage);
