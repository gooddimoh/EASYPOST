import React from 'react';
import { compose } from 'redux';
import PropTypes from 'prop-types';
import connect from 'Hoc/Template/Connect';
import { withTagDefaultProps } from 'Hoc/Template';
import { Aside, AsideHead, AsideBlock } from 'Templates/ViewInfo';

const propTypes = {
    data: PropTypes.objectOf(PropTypes.any).isRequired,
    config: PropTypes.arrayOf(PropTypes.func).isRequired,
    backUrl: PropTypes.string.isRequired,
    editUrl: PropTypes.func,
};

const defaultProps = {
    editUrl: () => {},
};

const AsideWidget = ({ data, config, backUrl, editUrl }) => {
    return (
        <Aside>
            <AsideHead backUrl={backUrl} editUrl={editUrl(data.id)} />
            {config.map((cb, index) => (cb ? <AsideBlock key={`config-${index}`}>{cb(data)}</AsideBlock> : null))}
        </Aside>
    );
};

AsideWidget.propTypes = propTypes;
AsideWidget.defaultProps = defaultProps;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        data: getStoreItem(state, 'view', {}),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, null))(AsideWidget);
