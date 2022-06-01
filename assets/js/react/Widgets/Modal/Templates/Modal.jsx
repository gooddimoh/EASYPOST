import React from 'react';
import { curry, isEmpty, not } from 'ramda';
import { close } from 'Widgets/Modal';
import { Header, Body, Footer } from 'Templates/Modal';
import { ServiceProvider } from 'Services/Context';

export default curry((content, buttons, params) => (index) => {
    const handledButtons = buttons.map((button, key) => {
        const { unclosed, onClick } = button.props;
        // TODO ramda rewrite if
        return React.cloneElement(button, {
            key,
            onClick: () => {
                if (onClick) onClick(params);
                if (!unclosed) close(index);
            },
        });
    });

    const onClick = () => {
        close(index);
    };

    const { title, service = {} } = content.props;
    const renderContent = React.cloneElement(content, { kModal: index });

    return (
        <div className="modal">
            <div className="modal__wrap">
                <Header onClick={onClick} title={title} />
                <Body>
                    <ServiceProvider value={service}>{renderContent}</ServiceProvider>
                </Body>
                {not(isEmpty(handledButtons)) && <Footer buttons={handledButtons} />}
            </div>
        </div>
    );
});
