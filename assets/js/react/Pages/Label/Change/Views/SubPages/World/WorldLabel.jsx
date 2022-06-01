import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import { FormContent } from 'Templates/Form';
import { SenderBlock, RecipientBlock, PackageFormBlock, OptionsWorldForm } from '../../FormBlocks';

const WorldLabel = () => {
    return (
        <FormContent>
            <SenderBlock />
            <RecipientBlock />
            <PackageFormBlock />
            <OptionsWorldForm />
        </FormContent>
    );
};

export default withTagDefaultProps(WorldLabel);
