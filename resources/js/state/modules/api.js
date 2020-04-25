export const baseApi = '/api/v1';

export const state = {
    login: `${baseApi}/login`,
    refreshToken: `${baseApi}/oauth/token`,
    logout: `${baseApi}/logout`,
    register: `${baseApi}/register`,

    me: `${baseApi}/me`,
    changePassword: `${baseApi}/me/password`,
    myTimesheet: `${baseApi}/me/timesheet`,
    singleMyTimesheet: (timesheetId) => `${baseApi}/me/timesheet/${timesheetId}`,

    user: `${baseApi}/user`,
    singleUser: (userId) => `${baseApi}/user/${userId}`,

    timesheet: `${baseApi}/timesheet`,
    singleTimesheet: (timesheetId) => `${baseApi}/timesheet/${timesheetId}`,
};
