import request from 'common/request';

export const state = {};

export const getters = {};

export const mutations = {};

export const actions = {
    /**
     * Get timesheet by given id
     * @param {Function} commit
     * @param rootState
     * @param {string} id
     */
    getTimesheet({commit, rootState}, id) {
        return request.get(rootState.api.singleTimesheet(id))
            .then((response) => (response.data.data));
    },

    /**
     * Update timesheet by given id
     * @param {Function} commit
     * @param rootState
     * @param {string} id
     * @param form
     */
    approveTimesheet({commit, rootState}, id) {
        return request.patch(rootState.api.approveTimesheet(id))
            .then((response) => (response.data.data));
    },
};

/**
 * Private Helpers.
 */
