import React from 'react';
import PropTypes from 'prop-types';
import {Pagination} from 'swiper';
import {Swiper, SwiperSlide} from 'swiper/react';
import NewsItem from '../../Pages/Dashboard/Index/Views/News/NewsItem';
import 'swiper/css';
import 'swiper/scss/pagination';

const propTypes = {
    data: PropTypes.arrayOf(PropTypes.any).isRequired,
};

const Slider = ({ data }) => {
    return (
        <Swiper
            spaceBetween={0}
            slidesPerView={1}
            pagination={{ clickable: true }}
            modules={[Pagination]}
            breakpoints={{
            815: {
                slidesPerView: 4,
            },
        }}
        >
            {data.map((item) => (
                <SwiperSlide key={item._id}>
                    <NewsItem item={item} />
                </SwiperSlide>
            ))}
        </Swiper>
    );
};

Slider.propTypes = propTypes;

export default Slider;