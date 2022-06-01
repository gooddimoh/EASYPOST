import { serviceProps } from 'Services';
import main from '../../../Services';

export default serviceProps(main.url, main.pref, {
    ...main,
    requestOnSubmit: (id) => main.requestOnSubmit(`${ main.url }/${id}/edit`),
});
