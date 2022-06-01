function Cache() {

    const _data = {};

    const _gc = () => {
        const now = new Date().getTime();
        Object.keys(_data).forEach(key => {
            if (_data[key].dieTime < now) {
                delete _data[key];
            }
        });
    };

    return {
        set: (key, data, { cacheLifeTime = 15 } = {}) => {
            _data[key] = { data, dieTime: new Date().getTime() + cacheLifeTime * 1000 };
        },

        get: key => {
            _gc();
            return _data[key] !== undefined ? _data[key].data : null;
        },
    };
}

export const cacheRequest = Cache();
