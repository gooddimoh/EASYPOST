import React from 'react';
import { getString, schemaCall } from 'Services';
import {DefaultSpan} from 'Templates/Content';

export const modifierValues = (items) => items;

export const getViewItem = schemaCall({
    _: (item, key) => <DefaultSpan title={getString(item, key)}/>,
});
