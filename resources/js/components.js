// The list of components register with Vue

import Vue from 'vue';

const prefix = 'timesheet-';

/**
 * Common components
 */
Vue.component(`${prefix}layout`, require('./components/common/layout/Wrapper').default);
Vue.component(`${prefix}table`, require('./components/common/Table').default);
Vue.component(`${prefix}modal`, require('./components/common/Modal').default);

/**
 * Form
 */
Vue.component(`${prefix}field`, require('./components/common/form/Field').default);
Vue.component(`${prefix}form-group`, require('./components/common/form/FormGroup').default);
Vue.component(`${prefix}ajax-select`, require('./components/common/form/AjaxSelect').default);
Vue.component(`${prefix}avatar`, require('./components/common/form/Avatar').default);
