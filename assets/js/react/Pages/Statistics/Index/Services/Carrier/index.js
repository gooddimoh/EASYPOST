import { compose } from 'ramda';
import { serviceProps } from 'Services';
import main from '../index';

const serviceKey = 'carrier';

export default serviceProps(main.url, main.pref, {
    ...main,
    serviceKey,
    requestOnSubmit: compose(main.requestOnSubmit(`/${main.url}/${serviceKey}`), main.formData),
});
