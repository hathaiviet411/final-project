import Layout from '@/layout';

const dashboard = {
    path: '/dashboard',
    name: 'Dashboard',
    meta: {
        title: 'ROUTER.DASHBOARD',
        icon: 'fas fa-chart-pie',
    },
    component: Layout,
    redirect: { name: 'DashboardIndex' },
    children: [
        {
            path: 'index',
            name: 'DashboardIndex',
            meta: {
                title: 'ROUTER.DASHBOARD',
            },
            component: () => import(/* webpackChunkName: "DashboardIndex" */ '@/pages/Dashboard/index'),
        },
    ],
};

export default dashboard;
