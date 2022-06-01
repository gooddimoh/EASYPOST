import { serviceProps } from 'Services';
import main from '../../../Services';

export default serviceProps(main.url, main.pref, {
    ...main,
    requestOnSubmit: () => main.requestOnSubmit(`${main.url}/create`),
});
