import React, { useState } from 'react';
import PropTypes from 'prop-types';
import { compose } from 'ramda';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { CustomOverlay } from 'Templates/CustomOverlay';
import { Img } from 'Templates/Img';
import { roleOptions } from 'Services/Enums';
import Balance from './Balance';

const propTypes = {
    user: PropTypes.shape({
        id: PropTypes.string.isRequired,
        photo: PropTypes.string.isRequired,
        fullName: PropTypes.string.isRequired,
        permissions: PropTypes.arrayOf(PropTypes.string).isRequired,
    }).isRequired,
};

const UserProfile = ({ user, t }) => {
    const [showList, setShowList] = useState(false);
    const handleSetShowList = () => setShowList(!showList);
    const { id, photo, fullName, permissions } = user;
    const { label: role } = roleOptions.find(({ value }) => value === permissions[0]);

    return (
        <div
            className={`header__user ${showList ? 'is-open' : ''}`}
            onClick={handleSetShowList}
            onKeyDown={handleSetShowList}
        >
            <div className="header__user-data">
                <span title={fullName} className="header__user-text">
                    {fullName}
                </span>
                <span title={role} className="header__user-subject">
                    {role}
                </span>
            </div>
            <button type="button" onClick={() => {}} className="header__user-logo">
                {photo ? <img src={`${photo}`} alt="user-pic" /> : <Img img="icon_contact_small" alt="user-pic" />}
            </button>
            <Img img="arrow-dropdown" alt="arrow-dropdown" />
            {showList && (
                <ul className="header__dropdown">
                    <li className="header__dropdown-item">
                        <a href={`/users/${id}`} className="header__dropdown-link">
                            {t('My profile')}
                        </a>
                    </li>
                    <li className="header__dropdown-item">
                        <a href={`/users/${id}/changePassword`} className="header__dropdown-link">
                            {t('Change password')}
                        </a>
                    </li>
                    <li className="header__dropdown-item">
                        <a href="/doc" className="header__dropdown-link">
                            {t('API Integration')}
                        </a>
                    </li>
                    <li className="header__dropdown-item">
                        <a href="/logout" className="header__dropdown-link">
                            {t('Log Out')}
                        </a>
                    </li>
                    <li className="header__dropdown-item header__dropdown-item_balance">
                        <Balance />
                    </li>
                </ul>
            )}
            <CustomOverlay onClick={handleSetShowList} show={!showList} />
        </div>
    );
};

UserProfile.propTypes = propTypes;

const mapStateToProps = (state) => {
    return {
        user: state.userState,
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps))(UserProfile);
