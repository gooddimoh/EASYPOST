import React from 'react';
import PropTypes from 'prop-types';
import { CheckPermission, UnCheckPermission } from 'Hoc/Template';
import { SidebarItem } from 'Templates/Sidebar';
// eslint-disable-next-line import/no-cycle
import DropdownMenu from './DropdownMenu';
import { sidebarOptions } from '../Config';

const defaultProps = {
    counter: 0,
};

const propTypes = {
    counter: PropTypes.number,
    map: PropTypes.objectOf(PropTypes.any).isRequired,
};

const propTypesItem = {
    item: PropTypes.objectOf(PropTypes.any).isRequired,
    counter: PropTypes.number.isRequired,
    menu: PropTypes.string.isRequired,
};

const RenderItem = ({ menu, counter, item }) => {
    return item.childrens ? (
        <DropdownMenu key={menu} counter={counter} label={menu} map={item}/>
    ) : (
        <SidebarItem key={menu} label={menu} map={item}/>
    );
};

const SidebarContent = ({ counter, map }) => {
    return (
        <>
            {Object.keys(map).map((menu, index) => {
                map[menu].options = {
                    ...sidebarOptions,
                    ...map.options,
                };

                const renderItem = <RenderItem menu={menu} counter={counter + 1} item={map[menu]}/>;

                if (map[menu].permissions_type === 'check') {
                    return <CheckPermission allowedPermissions={[map[menu].permissions]} key={index}>
                        {renderItem}
                    </CheckPermission>;
                }

                return <UnCheckPermission deniedPermissions={[map[menu].permissions]}  key={index}>
                    {renderItem}
                </UnCheckPermission>;

            })}
        </>
    );
};

SidebarContent.defaultProps = defaultProps;
SidebarContent.propTypes = propTypes;
RenderItem.propTypes = propTypesItem;

export default SidebarContent;
