import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';

const InfoCompanies = ({ t }) => {
    return <div className="info-manual__text">{t('Company Info')}</div>;
};

export default withTagDefaultProps(InfoCompanies);
