import Vue from 'vue';
import Vuex from 'vuex';

// Modules are automatically registered by the modules/index.js file.
import modules from './modules';

Vue.use(Vuex);

const store = new Vuex.Store({
    modules,
});

// Automatically run the `init` action for every module, if one exists.
// Prefix the init function with the module name.
// e.g. auth.js > authInit
for (const moduleName of Object.keys(modules)) {
    if (modules[moduleName].actions && modules[moduleName].actions[`${moduleName}Init`]) {
        store.dispatch(`${moduleName}Init`)
    }
}

export default store;
