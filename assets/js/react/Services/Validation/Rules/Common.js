import { isNil, isEmpty } from 'ramda';
import { ValidateDTO } from '../utils';
import { t } from '../../i18n';

export const required = (value, text = 'Field should not be empty') => {
    if (!isNil(value) && !isEmpty(value)) return new ValidateDTO(true);

    return new ValidateDTO(false, [t(text)]);
};
