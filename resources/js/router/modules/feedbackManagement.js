import Layout from '@/layout';

const feedbackManagement = {
    path: '/feedback-management',
    component: Layout,
    redirect: { name: 'FeedbackManagementList' },
    name: 'FeedbackManagement',
    meta: {
        title: 'ROUTER.FEEDBACK_MANAGEMENT',
        icon: 'fas fa-comment-alt-dots',
    },
    isHidden: '',
    children: [
        {
            path: 'list',
            name: 'FeedbackManagementList',
            meta: {
                title: 'ROUTER.FEEDBACK_MANAGEMENT',
            },
            component: () => import(/* webpackChunkName: "FeedbackManagementList" */ '@/pages/FeedbackManagement/list'),
        },
    ],
};

export default feedbackManagement;
