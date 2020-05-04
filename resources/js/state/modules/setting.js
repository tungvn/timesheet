import request from 'common/request';

export const state = {
    settings: {},
};

export const getters = {
    settings(state) {
        return state.settings || {};
    }
};

export const mutations = {
    SET_SETTINGS(state, settings = []) {
        state.settings = {
            ...settings.reduce((carry, setting) => ({
                ...(carry || {}),
                [setting.key]: {...setting},
            }), {}),
        };
    },
    SET_SETTING(state, setting) {
        state.settings = {
            ...state.settings,
            [setting.key]: {...setting},
        };
    },
};

export const actions = {
    /**
     * Get all settings
     * @param {Function} commit
     * @param rootState
     * @param {string} id
     */
    getSettings({commit, rootState}, id) {
        return request.get(rootState.api.setting)
            .then((response) => {
                commit('SET_SETTINGS', response && response.data && response.data.data || []);
            });
    },

    /**
     * Update setting by given id
     * @param {Function} commit
     * @param rootState
     * @param {string} id
     * @param form
     */
    updateSetting({commit, rootState}, {id, form}) {
        return form.patch(rootState.api.singleSetting(id))
            .then((response) => {
                commit('SET_SETTING', response.data);
            });
    },
};
