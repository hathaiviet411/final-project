import Layout from '@/layout';

const roomManagement = {
    path: '/room-management',
    component: Layout,
    redirect: { name: 'RoomManagementList' },
    name: 'RoomManagement',
    meta: {
        title: 'ROUTER.ROOM_MANAGEMENT',
        icon: 'fas fa-door-open',
    },
    children: [
        {
            path: 'index',
            name: 'RoomManagementList',
            meta: {
                title: 'ROUTER.ROOM_MANAGEMENT',
            },
            component: () => import(/* webpackChunkName: "RoomManagementList" */ '@/pages/RoomManagement/list'),
        },
    ],
};

export default roomManagement;
