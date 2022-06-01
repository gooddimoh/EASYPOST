import React from 'react';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import { Img } from 'Templates/Img';
import AsideBlock from './AsideBlock';

const propTypes = {
    backUrl: PropTypes.string.isRequired,
    editUrl: PropTypes.string,
};

const defaultProps = {
    editUrl: '',
};

const AsideHead = ({ backUrl, editUrl }) => {
    return (
        <AsideBlock>
            <div className="form-info__profile-arrow">
                <a href={backUrl} className="form-info__profile-icon">
                    <Img img="arrow-left" alt="arrow" />
                </a>
            </div>
            {editUrl && (
                <div className="form-info__profile-edit">
                    <a href={editUrl} className="form-info__profile-icon main-circle">
                        <Img img="icon_edit" alt="edit" />
                    </a>
                </div>
            )}
        </AsideBlock>
    );
};

AsideHead.propTypes = propTypes;
AsideHead.defaultProps = defaultProps;

export default withTagDefaultProps(AsideHead);
