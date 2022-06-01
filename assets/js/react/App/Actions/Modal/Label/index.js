import * as LabelActions from './LabelActions';
import * as FormActions from './FormActions';
import { requestGetBalance } from '../Payment/PaymentActions';

export default { ...FormActions, ...LabelActions, requestGetBalance };
