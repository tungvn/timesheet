window._ = require('lodash');

import Vue from 'vue';
window.Vue = Vue;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Form from 'form-backend-validation';
window.Form = Form;

import Toasted from 'vue-toasted';
Vue.use(Toasted, {
    keepOnHover: true,
    theme: 'toasted-primary',
    containerClass: 'app-toasted',
    position: 'top-center',
    duration: 5000,
});
