export const baseApi = '/api/v1';

export const state = {
    login: `${baseApi}/login`,
    refreshToken: `${baseApi}/oauth/token`,
    logout: `${baseApi}/logout`,
    register: `${baseApi}/register`,

    me: `${baseApi}/me`,
    changePassword: `${baseApi}/me/password`,

    listUsers: `${baseApi}/user`,
    singleUser: (userId) => `${baseApi}/user/${userId}`,
    restoreUser: (userId) => `${baseApi}/user/${userId}/restore`,
};
