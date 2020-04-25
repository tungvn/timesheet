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
        return request.get(rootState.api.timesheet)
            .then((response) => (response.data.data));
    },

    /**
     * Update timesheet by given id
     * @param {Function} commit
     * @param rootState
     * @param {Form} form
     */
    createTimesheet({commit, rootState}, form) {
        return form.post(rootState.api.timesheet)
            .then((response) => (response.data));
    },


    /**
     * Update timesheet by given id
     * @param {Function} commit
     * @param rootState
     * @param {string} id
     * @param form
     */
    updateTimesheet({commit, rootState}, {id, form}) {
        return form.patch(rootState.api.singleTimesheet(id))
            .then((response) => (response.data));
    },

    /**
     * Delete timesheet by given id
     * @param {Function} commit
     * @param rootState
     * @param {string} id
     */
    deleteTimesheet({commit, rootState}, id) {
        return request.delete(rootState.api.singleTimesheet(id));
    },
};

/**
 * Private Helpers.
 */
