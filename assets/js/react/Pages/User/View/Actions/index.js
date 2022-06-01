import { requestGetBalance } from 'App/Actions/Modal/Payment/PaymentActions';
import * as TableActions from './TableActions';
import * as PageActions from './PageActions';

export default { requestGetBalance, ...TableActions, ...PageActions };
