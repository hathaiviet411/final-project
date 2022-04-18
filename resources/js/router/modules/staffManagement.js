import Layout from '@/layout';

const staffManagement = {
    path: '/staff-management',
    component: Layout,
    redirect: { name: 'StaffManagementList' },
    name: 'StaffManagement',
    meta: {
        title: 'ROUTER.STAFF_MANAGEMENT',
        icon: 'fas fa-users',
    },
    children: [
        {
            path: 'list',
            name: 'StaffManagementList',
            meta: {
                title: 'ROUTER.STAFF_MANAGEMENT',
            },
            component: () => import(/* webpackChunkName: "StaffManagementList" */ '@/pages/StaffManagement/List'),
        },
        // {
        //     path: 'edit/:id',
        //     name: 'AccountItemMasterEdit',
        //     meta: {
        //         title: 'ROUTER.ACCOUNT_ITEM_MASTER_EDIT',
        //     },
        //     component: () => import(/* webpackChunkName: "AccountItemMasterEdit" */ '@/pages/MasterManagement/AccountItemMaster/Edit'),
        // },
    ],
};

export default staffManagement;
