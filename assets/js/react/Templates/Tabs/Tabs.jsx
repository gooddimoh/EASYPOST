import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps, CheckPermission } from 'Hoc/Template';
import Tab from './Tab';

const propTypes = {
    pref: PropTypes.string.isRequired,
    children: PropTypes.instanceOf(Array).isRequired,
    activeTab: PropTypes.number.isRequired,
    onClick: PropTypes.func.isRequired,
};

const TabsPermission = ({children, permission}) => {
    if(permission.length){
        return <CheckPermission allowedPermissions={permission}>
            {children}
        </CheckPermission>;
    }
    return children;
};

const Tabs = ({ pref, children, activeTab, onClick }) => {
    return (
        <div className={`tabs tabs_${pref}`}>
            <div className={`tabs__wrap tabs__wrap_${pref}`}>
                <div className={`tabs__list tabs__list_${pref}`}>
                    {children.map((child, index) => {
                        const { label, param = '', permission=[]} = child.props;
                        return (
                            <TabsPermission key={label} permission={permission}>
                                <Tab
                                    activeTab={activeTab === index}
                                    key={label}
                                    label={label}
                                    onClick={() => {
                                        if (activeTab !== index) {
                                            onClick(index, param);
                                        }
                                    }}
                                />
                            </TabsPermission>
                        );
                    })}
                </div>
            </div>

            <div className={`tabs__content tabs__content_${pref}`}>
                <div className={`tabs__item tabs__item_${pref}`}>{children[activeTab]}</div>
            </div>
        </div>
    );
};

Tabs.propTypes = propTypes;

export default withTagDefaultProps(Tabs);
