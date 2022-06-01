import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { formatDate, formatMaxDay30, checkInvalidDate } from 'Services';
import { WrapInput } from '../Form';
import { Input } from '../Input';

const propTypes = {
    title: PropTypes.string.isRequired,
    data: PropTypes.arrayOf(PropTypes.object).isRequired,
    children: PropTypes.node.isRequired,
    pref: PropTypes.string.isRequired,
    value: PropTypes.oneOfType([PropTypes.string, PropTypes.arrayOf(PropTypes.string)]).isRequired,
    onChange: PropTypes.func.isRequired,
};

const StatisticItem = ({ title, data, pref, children, value, onChange, t }) => {

    const myDate = (date) => new Date(date);
    const todayDate = formatDate(new Date(), "YYYY-MM-DD");
    const dateFrom = formatDate(value[0], "YYYY-MM-DD");

    const maxDay30 = () => {
        if(myDate(dateFrom).getTime() <= new Date().getTime()) {
            return checkInvalidDate(value[0]);
        }
        if(dateFrom <= todayDate) {
            return formatMaxDay30(value[0]);
        }

        return new Date();
    };

    return (
        <div className={`statistics__item statistics__item_${pref}`}>
            <div className={`statistics__title statistics__title_${pref}`}>{t(title)}</div>
            <div className={`statistics__body statistics__body_${pref}`}>
                <div className={`statistics__input statistics__input_${pref}`}>
                    <WrapInput name="name" label="Date">
                        <Input
                            type="dateRange"
                            value={value}
                            placeholder="Enter date"
                            onChange={onChange}
                            dayPickerProps={{
                                disabledDays: {
                                    after: maxDay30(),
                                    before: myDate(value[0])
                                },
                            }}
                        />
                    </WrapInput>
                </div>
            </div>
            <div className={`statistics__footer statistics__footer_${pref}`}>
                <div className={`statistics__block statistics__block_${pref}`}>
                    {data.map((item, index) => (
                        <div className={`statistics__text statistics__text_${pref}`} key={`${title}-${index}`}>
                            <span>{item.value}</span> {t(item.name)}
                        </div>
                    ))}
                </div>
                <div className={`statistics__graphic statistics__graphic_${pref}`}>{children}</div>
            </div>
        </div>
    );
};

StatisticItem.propTypes = propTypes;

export default withTagDefaultProps(StatisticItem);
