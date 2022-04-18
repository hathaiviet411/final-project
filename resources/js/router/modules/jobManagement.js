import Layout from '@/layout';

const jobManagement = {
    path: '/job-management',
    component: Layout,
    redirect: { name: 'JobManagementList' },
    name: 'JobManagement',
    meta: {
        title: 'ROUTER.JOB_MANAGEMENT',
        icon: 'fas fa-abacus',
    },
    children: [
        {
            path: 'index',
            name: 'JobManagementList',
            meta: {
                title: 'ROUTER.JOB_MANAGEMENT',
            },
            component: () => import(/* webpackChunkName: "JobManagementList" */ '@/pages/JobManagement/List'),
        },
    ],
};

export default jobManagement;
