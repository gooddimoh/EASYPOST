import React, { useEffect } from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import { withTagDefaultProps, PermissionsProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { PageWrap } from 'Templates/Content';
import { TopTitleWrap } from 'Templates/Title';
import { showModal, ask } from 'Widgets/Modal';
import { carriersPermission } from 'Services/Enums';
import EditModal from './Modal/EditModal';
import { CarrierCard, CarrierCardWrap, CarrierCardItem } from './CarrierCard';
import carriersJson from './carriers.json';

const propTypes = {
    service: PropTypes.shape({
        pref: PropTypes.string.isRequired,
    }).isRequired,
    showIndex: PropTypes.number.isRequired,
    items: PropTypes.arrayOf(PropTypes.object).isRequired,
    changeShowIndex: PropTypes.func.isRequired,
    deleteCarrier: PropTypes.func.isRequired,
    updateCarrier: PropTypes.func.isRequired,
    isGranted: PropTypes.func.isRequired,
};

const PageView = ({ showIndex, changeShowIndex, service, isGranted, items, deleteCarrier, updateCarrier, t }) => {
    const onClickEdit = (key) => () => changeShowIndex(key);

    useEffect(() => {
        if (showIndex < 0) return;
        showModal(<EditModal title="Edit carrier" service={service} />, () => changeShowIndex(-1));
    }, [showIndex]);

    const onDelete = async (index) => {
        await deleteCarrier(items[index]);
        updateCarrier();
    };

    const onClickDelete = (key) => () => ask('Do you want to delete the item?', () => onDelete(key));

    return (
        <>
            <TopTitleWrap title="Carriers" />
            <PageWrap>
                <div className="page-wrap__description">
                    {t(
                        'Select your shipping carrier for instant label creation. You can use our accounts with USPS, FedEx & UPS to take advantage of all the great features and benefits or you can use your own personal or business account.',
                    )}
                </div>
                <CarrierCardWrap>
                    {items.map((item, key) => (
                        <CarrierCardItem key={item.type}>
                            <div className="carrier__block">
                                <div className="carrier__title">{carriersJson[item.type].title}</div>
                                <ul className="carrier__sublist">
                                    {carriersJson[item.type].items.map((i, k) => (
                                        <li className="carrier__subitem" key={`${i}-${k}`}>
                                            {i}
                                        </li>
                                    ))}
                                </ul>
                            </div>
                            <CarrierCard
                                type={item.type}
                                title={item.name}
                                editable={item.editable && isGranted(carriersPermission[item.type])}
                                text={item.description}
                                flagLabel={item.custom}
                                onClickEdit={onClickEdit(key)}
                                onClickDelete={onClickDelete(key)}
                            />
                        </CarrierCardItem>
                    ))}
                </CarrierCardWrap>
            </PageWrap>
        </>
    );
};

PageView.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        items: getStoreItem(state, 'items', []),
        showIndex: getStoreItem(state, 'showIndex'),
    };
};

const mapDispatchToProps = ({ service }) => {
    const { getActionStore } = service;

    return {
        updateCarrier: getActionStore('updateCarrier'),
        changeShowIndex: getActionStore('changeShowIndex'),
        deleteCarrier: getActionStore('deleteCarrier'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps), PermissionsProps)(PageView);
