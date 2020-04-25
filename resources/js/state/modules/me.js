import request from 'common/request';
import {get} from 'tiny-cookie';
import {state as api} from './api';

export const state = {
    account: null,
};

export const getters = {
    /**
     * Get current account
     * @param {Object} state
     * @returns {Object}
     */
    account(state) {
        return state.account || null;
    },
};

export const mutations = {
    /**
     * Get the current account statement.
     */
    async GET_ACCOUNT(state) {
        state.account =  await getAccount();
    },

    /**
     * Set the current account statement.
     */
    SET_ACCOUNT(state, account) {
        state.account = {
            ...(state.account || {}),
            ...account,
        };
    },
};

export const actions = {
    /**
     * Add the current account statement
     */
    async meInit({commit}) {
        if (get(process.env.MIX_APP_COOKIE_LOGGED_IN)) {
            commit('SET_ACCOUNT', await getAccount());
        }
    },

    /**
     * Get current account.
     * @param {Function} commit
     * @param rootState
     */
    async getAccount({commit, rootState}) {
        commit('SET_ACCOUNT', await getAccount());
    },

    /**
     * Update current account.
     * @param {Function} commit
     * @param rootState
     * @param form
     */
    async updateMe({commit, rootState}, form) {
        return form.patch(api.me)
            .then((response) => {
                commit('SET_ACCOUNT', (response && response.data) || null);
            });
    },

    /**
     * Change password
     * @param {Function} commit
     * @param rootState
     * @param form
     */
    async changePassword({commit, rootState}, form) {
        return form.patch(api.changePassword);
    },

    /**
     * Get timesheet by given id
     * @param {Function} commit
     * @param rootState
     * @param {string} id
     */
    getMyTimesheet({commit, rootState}, id) {
        return request.get(rootState.api.singleMyTimesheet(id))
            .then((response) => (response.data.data));
    },

    /**
     * Update timesheet by given id
     * @param {Function} commit
     * @param rootState
     * @param {Form} form
     */
    createMyTimesheet({commit, rootState}, form) {
        return form.post(rootState.api.myTimesheet)
            .then((response) => (response.data));
    },

    /**
     * Update timesheet by given id
     * @param {Function} commit
     * @param rootState
     * @param {string} id
     * @param form
     */
    updateMyTimesheet({commit, rootState}, {id, form}) {
        return form.patch(rootState.api.singleMyTimesheet(id))
            .then((response) => (response.data));
    },

    /**
     * Delete timesheet by given id
     * @param {Function} commit
     * @param rootState
     * @param {string} id
     */
    deleteMyTimesheet({commit, rootState}, id) {
        return request.delete(rootState.api.singleMyTimesheet(id));
    },
};

/**
 * Private Helpers.
 */

async function getAccount() {
    return await request.get(api.me)
        .then((response) => {
            return (response && response.data && response.data.data) || null;
        });
}
