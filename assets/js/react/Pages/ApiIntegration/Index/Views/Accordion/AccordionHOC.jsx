import React, { useState } from 'react';
import { compose } from 'ramda';
import { withTagDefaultProps } from 'Hoc/Template';

const AccordionHoc =
    (Wrapped) =>
        ({ submitAction, ...other }) => {
            const [active, setActive] = useState(false);

            const handleSetActive = () => {
                setActive(!active);
            };

            const className = active ? 'active' : '';

            /* eslint-disable-next-line react/jsx-props-no-spreading */
            return <Wrapped className={className} handleSetActive={handleSetActive} {...other} />;
        };

export default compose(withTagDefaultProps, AccordionHoc);
