import React from 'react';
import { withTagDefaultProps } from 'Hoc/Template';

const InfoTransactions = ({ t }) => {
    return (
        <div className="info-manual__text">
            {t(
                'It’s easy to keep track of your business activities by recording every commercial transaction in a consolidated manner. In this way, there should be no confusion that could be detrimental to the interests of your enterprise. Adopt a balance sheet approach of excess of liabilities over your assets and be able to print out a financial statement to see what your expenditures are. Consistent financial reporting is considered a major step towards improving your capacity to issue an invoice on short notice or pay off your arrears. Click “Add transaction”, fill in the form, then press “Save”.',
            )}
        </div>
    );
};

export default withTagDefaultProps(InfoTransactions);
