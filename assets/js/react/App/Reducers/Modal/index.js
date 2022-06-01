import { schemaReducer } from 'Services';
import { initState as paymentState, reducer as paymentReducer } from './Payment/PaymentReducer';
import { initState as labelState, reducer as labelReducer } from './Label/LabelReducer';
import { initState as labelFormState, reducer as labelFormReducer } from './Label/FormReducer';
import { initState as registrationState, reducer as registrationReducer } from './Registration/Reducer';

export const initState = {
    payment: paymentState,
    label: { ...labelFormState, ...labelState },
    registration: registrationState,
};

export const reducer = {
    ...paymentReducer,
    ...labelReducer,
    ...labelFormReducer,
    ...registrationReducer,
};

export default schemaReducer(initState, reducer);
