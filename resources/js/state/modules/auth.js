import request from 'common/request';
import {get, set} from 'tiny-cookie';
import {state as api} from './api';
import router from '../../router/routes';

export const state = {
    loggedIn: get(process.env.MIX_APP_COOKIE_LOGGED_IN),
};

export const getters = {
    /**
     * Check if user is logged in.
     * @param {Object} state
     * @returns {boolean}
     */
    loggedIn(state) {
        return !!state.loggedIn;
    },
};

export const mutations = {
    /**
     * Set the logged in statement.
     */
    SET_ACCESS_TOKEN(state, loggedIn) {
        setLoggedIn(state, loggedIn);
    },

    CLEAR_LOGIN_COOKIE(state) {
        const domain = extractHostname(process.env.MIX_APP_URL);
        set(process.env.MIX_APP_COOKIE_LOGGED_IN, '0', {expires: -1, domain: domain});
    }
};

export const actions = {
    /**
     * Add the login statement
     */
    authInit({state}) {
        state.loggedIn = get(process.env.MIX_APP_COOKIE_LOGGED_IN);
    },

    /**
     * Logs the user in.
     * @param {Function} commit
     * @param rootState
     * @param {Form} form
     */
    login({commit, rootState}, form) {
        return form.post(rootState.api.login)
            .then(() => {
                commit('SET_ACCESS_TOKEN', true);
            });
    },

    /**
     * Log a user out.
     * @param {Function} commit
     * @param rootState
     */
    logout({commit, rootState}) {
        return request.post(rootState.api.logout)
            .then(response => (response && response.data))
            .catch(error => (error && error.data))
            .then(() => {
                commit('CLEAR_LOGIN_COOKIE');
                commit('SET_ACCESS_TOKEN', false);
                location.reload();
            });
    },

    /**
     * Register a new user.
     * @param {Object} commit
     * @param rootState
     * @param form
     */
    register({commit, rootState}, form) {
        return form.post(rootState.api.register);
    },

    /**
     * Refresh token
     * @param {Function} commit
     * @param rootState
     */
    refreshToken({commit, rootState}) {
        let form = new Form({
            grant_type: 'refresh_token',
            client_id: process.env.MIX_CLIENT_ID,
            client_secret: process.env.MIX_CLIENT_SECRET,
            scope: '',
        });

        return form.post(api.refreshToken)
            .then(response => {
                setLoggedIn(rootState.auth, true);
                return response;
            })
            .catch(() => {
                setLoggedIn(rootState.auth, false);
                commit('CLEAR_LOGIN_COOKIE');
                return null;
            });
    },
};

/**
 * Private Helpers.
 */
function setLoggedIn(state, loggedIn) {
    state.loggedIn = loggedIn;

    if (!loggedIn) {
        router.push('/login');
    }
}

function extractHostname(url) {
    var hostname;
    //find & remove protocol (http, ftp, etc.) and get hostname

    if (url.indexOf("//") > -1) {
        hostname = url.split('/')[2];
    } else {
        hostname = url.split('/')[0];
    }

    //find & remove port number
    hostname = hostname.split(':')[0];
    //find & remove "?"
    hostname = hostname.split('?')[0];

    return hostname;
}
