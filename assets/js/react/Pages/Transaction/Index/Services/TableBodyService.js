import React from 'react';
import {identity, negate, always} from "ramda";
import {getString, schemaCall, formatDate} from 'Services';
import {DefaultSpan, StatusLabel} from 'Templates/Content';
import {transactionType, transactionStatusOptions} from 'Services/Enums';
import {Balance} from "../Views/TableItems";

export const modifierValues = (items) => items;

const typeCall = (credit, debit) => schemaCall({
    [transactionType.credit]: credit,
    [transactionType.debit]: debit,
});

const balanceCheck = typeCall(identity, negate);
const typeCheck = typeCall(always('credit'), always('debit'));

export const getViewItem = schemaCall({
    date: (item, key) => <DefaultSpan title={formatDate(getString(item, key))}/>,
    balance: (item) => <Balance balance={balanceCheck(item.type, item.balance)}/>,
    type: (item) => <DefaultSpan title={typeCheck(item.type)}/>,
    status: (item) => <StatusLabel data={transactionStatusOptions} value={item.status} />,
    _: (item, key) => <DefaultSpan title={getString(item, key)}/>,
});
