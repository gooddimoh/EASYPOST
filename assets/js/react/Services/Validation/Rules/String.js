import { isEmail } from 'validator';
import { t } from 'Services/i18n';
import { safeValid, ValidateDTO } from '../utils';

export const email = safeValid((value) => {
    if (isEmail(value)) return new ValidateDTO(true);

    return new ValidateDTO(false, [t('Field should have only email')]);
});

export const moreThanOne = safeValid((value) => {
    const valid = value.split(' ').length >= 2;
    if (valid) return new ValidateDTO(true);

    return new ValidateDTO(false, [t('The field must contain two words')]);
});
