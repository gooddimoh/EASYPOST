import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import { FormContent } from 'Templates/Form';
import { SenderBlock, RecipientBlock, OptionsLocalForm } from '../../FormBlocks';

const LocalLabel = () => {
    return (
        <FormContent>
            <SenderBlock />
            <RecipientBlock />
            <OptionsLocalForm />
        </FormContent>
    );
};

export default withTagDefaultProps(LocalLabel);
