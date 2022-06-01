import React, { useLayoutEffect } from 'react';

function useWindowSize(onResize, onInitSize, ref) {
    useLayoutEffect(() => {
        const block = ref.current;

        const getSize = (el) => ({
            width: el.clientWidth,
            height: el.clientHeight,
            full: `${el.clientWidth},${el.clientHeight}`,
        });

        let size = getSize(block);
        let resizeTimerId;

        onInitSize(size.width, size.height);

        setInterval(() => {
            window.requestAnimationFrame(() => {
                const _size = getSize(block);

                if (size.full !== _size.full) {
                    size = _size;

                    if (resizeTimerId) {
                        clearTimeout(resizeTimerId);
                    }

                    resizeTimerId = setTimeout(() => {
                        onResize(_size.width, _size.height);
                    }, 150);
                }
            });
        }, 50);
    }, []);
}

const ResizeDetector = ({ children, onInitSize, onResize }) => {
    const elementRef = React.useRef(null);
    useWindowSize(onResize, onInitSize, elementRef);

    return <div ref={elementRef}>{children}</div>;
};

export default ResizeDetector;
