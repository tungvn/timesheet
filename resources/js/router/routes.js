import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '../state/store';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'homepage',
        component: require('./views/homepage/Index').default,
        meta: {
            redirectIfAuthenticated: true
        }
    },
    {
        path: '/login',
        name: 'login',
        component: require('./views/auth/Login').default,
        meta: {
            redirectIfAuthenticated: true,
        }
    },
    {
        path: '/register',
        name: 'register',
        component: require('./views/auth/Register').default,
        meta: {
            redirectIfAuthenticated: true,
        }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: require('./views/dashboard/Index').default,
        meta: {
            auth: true
        }
    },
];

const router = new VueRouter({
    routes
});

/**
 * Middlewares.
 */

// Auth middleware.
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.auth)) {
        if (!store.getters.loggedIn) {
            next({path: '/login'});
            return;
        }
    }

    next();
});

// Redirect if authenticated.
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.redirectIfAuthenticated)) {
        if (store.getters.loggedIn) {
            next({path: '/dashboard'});
            return;
        }
    }

    next();
});

export default router;
