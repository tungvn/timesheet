// The list of components register with Vue

import Vue from 'vue';

const prefix = 'timesheet-';

/**
 * Common components
 */

/**
 * Form
 */
Vue.component(`${prefix}field`, require('./components/common/form/Field').default);
