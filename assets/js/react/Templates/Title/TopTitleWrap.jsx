import React, { useState } from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { ShowPageDescription } from 'InfoManual';
import { Img } from 'Templates/Img';
import PageTitle from './PageTitle';

const propTypes = {
    title: PropTypes.string.isRequired,
    pref: PropTypes.string.isRequired,
    children: PropTypes.node,
    info: PropTypes.node,
};

const defaultProps = {
    children: null,
    info: null,
};

const TopTitleWrap = ({ title, pref, children, info }) => {
    const [toggle, setToggle] = useState(false);

    const afterClick = (
        <button type="button" className={`after-btn ${toggle ? 'active' : ''}`} onClick={() => setToggle(!toggle)}>
            <Img img="arrow-dropdown" alt="toggle-info" />
        </button>
    );

    return (
        <>
            <div className={`title-container title-container_${pref}`}>
                <PageTitle title={title} after={info && afterClick} />
                {children}
            </div>
            {info && <ShowPageDescription toggle={toggle}>{info}</ShowPageDescription>}
        </>
    );
};

TopTitleWrap.propTypes = propTypes;
TopTitleWrap.defaultProps = defaultProps;

export default withTagDefaultProps(TopTitleWrap);
