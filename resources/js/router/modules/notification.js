import Layout from '@/layout/index.vue';

const Notification = {
    path: '/notification',
    name: 'notification',
    component: Layout,
    redirect: '/notification/index',
    meta: {
        title: 'ROUTER.NOTIFICATION',
        icon: 'fas fa-comment-alt-lines',
        // roles: []
    },
    children: [
        {
            path: 'index',
            name: 'notification-index',
            component: () => import('@/pages/Notification/index.vue'),
            meta: {
                title: 'ROUTER.NOTIFICATION.INDEX',
            },
        },
    ],
};

export default Notification;
