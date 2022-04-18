import Vue from 'vue';
import Vuex from 'vuex';

// Import modules
import app from './modules/app';
import user from './modules/user';
import time from './modules/time';
import department from './modules/department';
import permissions from './modules/permissions';
import userManagement from './modules/user-management';

// Import getters
import getters from './getters';

Vue.use(Vuex);

const modules = {
    app,
    user,
    time,
    department,
    permissions,
    userManagement,
};

const store = new Vuex.Store({
    modules,
    getters,
});

export default store;
