export const baseApi = '/api/v1';
export const adminBaseApi = 'admin/api/v1';

export const state = {
    login: `${baseApi}/login`,
    refreshToken: `${baseApi}/oauth/token`,
    logout: `${baseApi}/logout`,
    register: `${baseApi}/register`,

    me: `${baseApi}/me`,
    changePassword: `${baseApi}/me/password`,
    myTimesheet: `${baseApi}/me/timesheet`,
    singleMyTimesheet: (timesheetId) => `${baseApi}/me/timesheet/${timesheetId}`,

    user: `${adminBaseApi}/user`,
    singleUser: (userId) => `${adminBaseApi}/user/${userId}`,
    getUserSelection: `${baseApi}/user/selection`,

    timesheet: `${baseApi}/timesheet`,
    singleTimesheet: (timesheetId) => `${baseApi}/timesheet/${timesheetId}`,
    approveTimesheet: (timesheetId) => `${baseApi}/timesheet/${timesheetId}/approve`,

    setting: `${adminBaseApi}/setting`,
    singleSetting: (settingId) => `${adminBaseApi}/setting/${settingId}`,
};
