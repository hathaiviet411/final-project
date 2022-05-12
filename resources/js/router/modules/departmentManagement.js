import Layout from '@/layout';

const departmentManagement = {
    path: '/department-management',
    component: Layout,
    redirect: { name: 'DepartmentManagementList' },
    name: 'DepartmentManagement',
    meta: {
        title: 'ROUTER.DEPARTMENT_MANAGEMENT',
        icon: 'fas fa-building',
    },
    isHidden: 'staff',
    children: [
        {
            path: 'list',
            name: 'DepartmentManagementList',
            meta: {
                title: 'ROUTER.DEPARTMENT_MANAGEMENT',
            },
            component: () => import(/* webpackChunkName: "DepartmentManagementList" */ '@/pages/DepartmentManagement/list'),
        },
    ],
};

export default departmentManagement;
