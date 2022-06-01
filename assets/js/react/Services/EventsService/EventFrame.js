export const eventFrame = () => {
    let ticking = false;

    return new Promise(resolve => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                resolve();

                ticking = false;
            });

            ticking = true;
        }
    });
};

