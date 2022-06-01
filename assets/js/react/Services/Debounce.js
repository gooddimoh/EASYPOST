let time = null;

export function debounce(fn, wait = 500, ...args) {
    if (typeof fn !== 'function') {
        throw new TypeError('Expected a function');
    }

    if (typeof wait !== 'number') {
        throw new TypeError('Expected value \'wait\' a number');
    }

    if (time) clearTimeout(time);

    return new Promise(res => {
        time = setTimeout(() => {
            res(fn.apply(this, args));
        }, wait);
    });
}
