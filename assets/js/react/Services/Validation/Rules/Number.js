import { isNumeric } from 'validator';
import { t } from 'Services/i18n';
import { safeValid, ValidateDTO } from '../utils';

export const numbers = safeValid((value) => {
    if (isNumeric(value)) return new ValidateDTO(true);

    return new ValidateDTO(false, [t('Field should have only number values')]);
});

export const money = safeValid((value) => {
    if (value.length < 9) return new ValidateDTO(true);

    return new ValidateDTO(false, [t('Field should have no more than 8 characters')]);
});
