const ErrorPage = {
    path: '/error-page',
    name: 'ErrorPage',
    hidden: true,
    component: () => import(/* webpackChunkName: "ErrorPage" */ '@/pages/ErrorPage/index'),
};

export default ErrorPage;
