import axios from 'axios';
import store from '../state/store';
import {state as api} from '../state/modules/api';
import router from "../router/routes";

const request = axios.create();

let isCalledRefreshToken = false;
let refreshSubscribers = [];

request.interceptors.request.use(config => {
    store.commit('LOADING');

    return config;
}, error => {
    store.commit('LOADED');

    return Promise.reject(error);
});

request.interceptors.response.use(
    response => {
        store.commit('LOADED');

        return response;
    },
    async error => {
        store.commit('LOADED');

        const errorResponse = error && error.response;
        const originalRequest = errorResponse.config;

        if (isTokenExpiredError(errorResponse)) {
            if (!isCalledRefreshToken) {
                isCalledRefreshToken = true;
                store.dispatch('refreshToken')
                    .then(response => {
                        isCalledRefreshToken = false;
                        onRefreshTokenFetched(`${response.token_type} ${response.access_token}`);
                    });
            }

            return new Promise((resolve, reject) => {
                subscribeTokenRefresh(token => {
                    // Replace the expired token and retry
                    originalRequest.headers['Authorization'] = token;
                    resolve(request.request(originalRequest));
                });
            });
        }

        if (errorResponse.status === 422) {
            error.response.data.message = null;
        }

        return Promise.reject(error);
    });

const isTokenExpiredError = (errorResponse) => {
    return errorResponse.status === 401 && errorResponse.config.url !== api.login && router.currentRoute.name !== 'login';
};

const subscribeTokenRefresh = (callback) => {
    refreshSubscribers.push(callback);
};

const onRefreshTokenFetched = (token) => {
    refreshSubscribers.map((callback) => callback(token));
    refreshSubscribers = [];
};

export default request;
