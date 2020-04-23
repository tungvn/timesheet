// The list of components register with Vue

import Vue from 'vue';

const prefix = 'timesheet-';

/**
 * Common components
 */
Vue.component(`${prefix}layout`, require('./components/common/layout/Wrapper').default);
Vue.component(`${prefix}table`, require('./components/common/Table').default);

/**
 * Form
 */
Vue.component(`${prefix}field`, require('./components/common/form/Field').default);
Vue.component(`${prefix}form-group`, require('./components/common/form/FormGroup').default);
