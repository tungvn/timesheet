export const state = {
    loading: 0,
};

export const getters = {
    loading(state) {
        return state.loading;
    }
};

export const mutations = {
    /**
     * Set the loading statement.
     */
    LOADING(state) {
        state.loading++;
    },

    /**
     * Set the logged in statement.
     */
    LOADED(state) {
        if (state.loading > 0) {
            state.loading--;
        }
    },
};

export const actions = {
    //
};
