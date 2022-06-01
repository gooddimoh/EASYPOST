import React, {useState} from 'react';
import { withTagDefaultProps } from 'Hoc/Template';
import { FormRow } from 'Templates/Form';
import { BackLink } from 'Templates/Title';
import { Registration, Success } from './Views';

const Index = ({ pref, t }) => {
    const [success, setSuccess] = useState(false);

    return (
        <div className={`main-wrap main-wrap_${pref} auth`}>
            <div className={`auth__wrap auth__wrap_${pref}`}>
                <div className={`auth__content auth__content_${pref}`}>
                    <FormRow>
                        <div className={`auth__box auth__box-title auth__box_${pref} auth__box-title_${pref}`}>
                            <BackLink url="/login" />
                            <div className={`auth__title auth__title_${pref}`}>{t('Registration')}</div>
                        </div>
                    </FormRow>
                    {success ? <Success /> : <Registration setSuccess={setSuccess} />}
                </div>
            </div>
        </div>
    );
};


export default withTagDefaultProps(Index);
