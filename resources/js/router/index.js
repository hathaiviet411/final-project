import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

// Import modules router
import login from './modules/login';
import dashboard from './modules/dashboard';
import timesheet from './modules/timesheet';
import scheduleManagement from './modules/scheduleManagement';
import facilityMaintenance from './modules/facilityMaintenance';
import roomManagement from './modules/roomManagement';
import jobManagement from './modules/jobManagement';
import staffManagement from './modules/staffManagement';
import departmentManagement from './modules/departmentManagement';
import feedbackManagement from './modules/feedbackManagement';
import dev from './modules/dev';

export const constantRoutes = [
    {
        path: '/',
        redirect: { name: 'Dev' },
        hidden: true,
    },
    login,
    dashboard,
    timesheet,
    scheduleManagement,
    facilityMaintenance,
    roomManagement,
    jobManagement,
    staffManagement,
    departmentManagement,
    feedbackManagement,
    dev,
];

export const asyncRoutes = [];

const createRouter = () => new VueRouter({
    mode: 'history',
    scrollBehavior: () => ({ y: 0 }),
    routes: constantRoutes,
});

const router = createRouter();

export function resetRouter() {
    const newRouter = createRouter();
    router.matcher = newRouter.matcher;
}

export default router;

