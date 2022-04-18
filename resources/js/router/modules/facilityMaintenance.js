import Layout from '@/layout';

const facilityMaintenance = {
    path: '/facility-management',
    component: Layout,
    redirect: { name: 'FacilityMaintenanceList' },
    name: 'FacilityMaintenance',
    meta: {
        title: 'ROUTER.FACILITY_MAINTENANCE',
        icon: 'fas fa-hand-receiving',
    },
    children: [
        {
            path: 'list',
            name: 'FacilityMaintenanceList',
            meta: {
                title: 'ROUTER.FACILITY_MAINTENANCE',
            },
            component: () => import(/* webpackChunkName: "FacilityMaintenanceList" */ '@/pages/FacilityMaintenance/List'),
        },
    ],
};

export default facilityMaintenance;
