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
    children: [
        {
            path: 'list',
            name: 'DepartmentManagementList',
            meta: {
                title: 'ROUTER.DEPARTMENT_MANAGEMENT',
            },
            component: () => import(/* webpackChunkName: "DepartmentManagementList" */ '@/pages/DepartmentManagement/List'),
        },
    ],
};

export default departmentManagement;
