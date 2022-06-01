const useContainer = {
    state: null,

    set(data) {
        this.state = data;
    },

    get() {
        return this.state;
    },
};

export default useContainer;
