import Layout from '@/layout';

const taskManagement = {
    path: '/task-management',
    component: Layout,
    redirect: { name: 'TaskManagementList' },
    name: 'TaskManagement',
    meta: {
        title: 'ROUTER.TASK_MANAGEMENT',
        icon: 'fas fa-abacus',
    },
    isHidden: 'staff',
    children: [
        {
            path: 'index',
            name: 'TaskManagementList',
            meta: {
                title: 'ROUTER.TASK_MANAGEMENT',
            },
            component: () => import(/* webpackChunkName: "TaskManagementList" */ '@/pages/TaskManagement/list'),
        },
    ],
};

export default taskManagement;
