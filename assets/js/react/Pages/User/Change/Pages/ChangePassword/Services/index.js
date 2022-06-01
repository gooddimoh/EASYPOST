import { serviceProps } from 'Services';
import main from '../../../Services';
import {validOnSubmit} from './ValidateService';

export default serviceProps(main.url, main.pref, {
    ...main,
    requestOnSubmit: () => main.requestOnSubmit(`/auth/change-password`),
    validOnSubmit
});
