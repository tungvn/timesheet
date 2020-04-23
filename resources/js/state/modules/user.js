import request from 'common/request';

export const state = {

};

export const getters = {

};

export const mutations = {

};

export const actions = {
    /**
     * Delete user by given id
     * @param {Function} commit
     * @param rootState
     * @param {string} id
     */
    deleteUser({commit, rootState}, id) {
        return request.delete(rootState.api.singleUser(id));
    },
};

/**
 * Private Helpers.
 */
