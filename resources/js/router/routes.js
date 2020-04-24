import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '../state/store';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
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

    {
        path: '/me',
        name: 'me',
        component: require('./views/me/Index').default,
        meta: {
            auth: true
        }
    },

    {
        path: '/users',
        name: 'users',
        component: require('./views/user/Index').default,
        meta: {
            auth: true
        },
    },

    {
        path: '/user/:id?',
        name: 'user',
        component: require('./views/user/Edit').default,
        meta: {
            auth: true
        },
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
            next({path: '/'});
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
