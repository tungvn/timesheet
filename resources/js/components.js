// The list of components register with Vue

import Vue from 'vue';

const prefix = 'timesheet-';

/**
 * Common components
 */
Vue.component(`${prefix}icon`, require('./components/common/Icon').default);

/**
 * Form
 */
Vue.component(`${prefix}field`, require('./components/common/form/Field').default);
