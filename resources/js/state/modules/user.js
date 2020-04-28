import request from 'common/request';

export const state = {

};

export const getters = {

};

export const mutations = {

};

export const actions = {
    /**
     * Get user by given id
     * @param {Function} commit
     * @param rootState
     * @param {string} id
     */
    getUser({commit, rootState}, id) {
        return request.get(rootState.api.singleUser(id))
            .then((response) => (response.data.data));
    },

    /**
     * Update user by given id
     * @param {Function} commit
     * @param rootState
     * @param {Form} form
     */
    createUser({commit, rootState}, form) {
        return form.post(rootState.api.user)
            .then((response) => (response.data));
    },


    /**
     * Update user by given id
     * @param {Function} commit
     * @param rootState
     * @param {string} id
     * @param form
     */
    updateUser({commit, rootState}, {id, form}) {
        return form.post(rootState.api.singleUser(id))
            .then((response) => (response.data));
    },

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
