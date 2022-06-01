import React from 'react';
import { compose } from 'ramda';
import { withTagDefaultProps } from 'Hoc/Template';

const Separator = () => <div className="header__separator" />;

export default compose(withTagDefaultProps)(Separator);
