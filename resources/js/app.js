/**
 * Bootstrap the application.
 */
require('./bootstrap');

/**
 * Import Vuex and Vue-router.
 */
import router from './router/routes';
import store from './state/store';

/**
 * Register Custom Vue Components.
 */
require('./components');

/**
 * Creates the Vue Instance.
 */
const app = new Vue({
    router, store,
}).$mount('#root');

window.vm = app;
