import React, { useCallback, useMemo } from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { BorderButton } from 'Templates/Button';
import { Spinloader } from 'Templates/Preloader';
import { FormError } from 'Templates/Form';
import { Img } from 'Templates/Img';
import { usePlaidLink } from 'react-plaid-link';

const propTypes = {
    token: PropTypes.string.isRequired,
    success: PropTypes.func.isRequired,
};

const PlaidLink = ({ token, success, t }) => {
    const onSuccess = useCallback(async (public_token, metadata) => {
        if (metadata.accounts.length) {
            await success(public_token, metadata.accounts[0].id);
        }
    }, []);

    const config = useMemo(() => ({ token, onSuccess }), []);
    const { open, ready, error } = usePlaidLink(config);

    return (
        <>
            <BorderButton fullWidth name="pay" onClick={open} disabled={!ready}>
                <Spinloader show={!ready} />
                <Img img="icon_lock" alt="lock" />
                {t('Connect a bank account')}
            </BorderButton>
            {error && <FormError title={error.error_message} />}
        </>
    );
};

PlaidLink.propTypes = propTypes;

export default withTagDefaultProps(PlaidLink);
