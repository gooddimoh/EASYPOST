import React from 'react';
import { withTranslation } from 'Services/i18n';
import { withServiceConsumer } from 'Services/Context';
import { compose } from 'redux';

const withTagDefaultProps = (Wrapped) => ({ service, ...other }) => (
    <Wrapped t={withTranslation} pref={service?.pref || 'default-pref'} service={service} {...other} />
);

export default compose(
    withServiceConsumer,
    withTagDefaultProps
);
