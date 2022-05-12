import Layout from '@/layout';

const timesheet = {
    path: '/timesheet',
    component: Layout,
    redirect: { name: 'TimesheetIndex' },
    name: 'Timesheet',
    meta: {
        title: 'ROUTER.TIMESHEET',
        icon: 'fas fa-table',
    },
    isHidden: '',
    children: [
        {
            path: 'index',
            name: 'TimesheetIndex',
            meta: {
                title: 'ROUTER.TIMESHEET',
            },
            component: () => import(/* webpackChunkName: "TimesheetIndex" */ '@/pages/Timesheet/index'),
        },
    ],
};

export default timesheet;
