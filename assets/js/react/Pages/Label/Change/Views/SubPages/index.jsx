import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { schema } from 'Services';
import { labelType } from 'Services/Enums';
import WorldLabel from './World/WorldLabel';
import LocalLabel from './Local/LocalLabel';

const propTypes = {
    type: PropTypes.string.isRequired,
};

const renderType = schema({
    [labelType.world]: () => <WorldLabel />,
    [labelType.local]: () => <LocalLabel />,
});

const Index = ({ type }) => renderType(type)();

Index.propTypes = propTypes;

export default withTagDefaultProps(Index);
