import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { FormRow, FormDesc } from 'Templates/Form';
import { DefaultButton } from 'Templates/Button';

const propTypes = {
    t: PropTypes.func.isRequired,
};

const Bitcoin = ({ t }) => {
    return (
        <>
            <FormRow>
                <FormDesc
                    title={[
                        'ATTENTION: After you transfer, please let us know',
                        'Bitcoin (BTC) - pay to 13KwfHtmWcyKtauXtnTVtkpAmTT2MFMntz',
                    ]}
                />
            </FormRow>
            <FormRow>
                <DefaultButton fullWidth name="pay" onClick={() => {}}>
                    {t('Send us notification dashboard payment')}
                </DefaultButton>
            </FormRow>
        </>
    );
};

Bitcoin.propTypes = propTypes;

export default withTagDefaultProps(Bitcoin);
