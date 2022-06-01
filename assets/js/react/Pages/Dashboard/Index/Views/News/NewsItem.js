import React from 'react';
import PropTypes from 'prop-types';
import { Img, ImgStorage } from 'Templates/Img';

const propTypes = {
    item: PropTypes.shape({
        id: PropTypes.string.isRequired,
        title: PropTypes.string.isRequired,
        description: PropTypes.string.isRequired,
        link: PropTypes.string.isRequired,
        photo: PropTypes.string.isRequired,
    }).isRequired,
};

const NewsItem = ({ item }) => {
    const { title, description, link, photo } = item;

    return (
        <div className="news__item">
            <a href={link} target="_blank" rel="noreferrer" className="news__link">
                <div className="news__photo">
                    {photo ? (
                        <ImgStorage url={photo} alt="aside-logo" />
                    ) : (
                        <Img img="icon_default-user" alt="aside-logo" />
                    )}
                </div>
                <div className="news__title">{title}</div>
                <div className="news__description">{description}</div>
            </a>
        </div>
    );
};

NewsItem.propTypes = propTypes;

export default NewsItem;
