import {useState, useEffect} from "react";

function useForceUpdate() {
    const c = { init: false };
    const [value, setValue] = useState(true);

    useEffect(() => {
        c.init = true;
        return () => c.init = false;
    }, []);

    return (delay = 0) => {
        setTimeout(() => {
            if (c.init) {
                setValue(!value);
            }
        }, delay);
    };
}

export default useForceUpdate;
