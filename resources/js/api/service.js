import axios from 'axios';
import i18n from '@/lang';
import store from '@/store';
import router from '@/router';
import CONST_AUTH from '@/const/auth';
import { getToken } from '@/utils/handleToken';
import { getLanguage } from '@/lang/helper/getLang';
import { MakeToast } from '@/utils/MakeToast';

const baseURL = process.env.MIX_BASE_API;

const service = axios.create({
    baseURL: baseURL,
    timeout: 100000,
});

service.interceptors.request.use(
    config => {
        const token = getToken();
        config.headers['Accept-Language'] = getLanguage();

        if (token) {
            config.headers['Authorization'] = token;
        } else {
            if (router.currentRoute.path !== '/login') {
                router.push({ path: '/login' });
            }
        }

        return config;
    },
    error => {
        Promise.reject(error);
    }
);

service.interceptors.response.use(
    response => {
        const USER_NOT_FOUND = CONST_AUTH.USER_NOT_FOUND;

        if (USER_NOT_FOUND.code === 404 && response.data.code === 404) {
            store.dispatch('user/doLogout')
                .then(() => {
                    router.push('/login');

                    MakeToast({
                        variant: 'danger',
                        title: i18n.t('SESSION_TIMEOUT.TITLE'),
                        content: i18n.t('SESSION_TIMEOUT.MESSAGE'),
                    });
                })
                .catch(() => {
                    MakeToast({
                        variant: 'danger',
                        title: i18n.$t('TOAST.TITLE.ERROR'),
                        content: i18n.t('TOAST.CONTENT.OTHER.ERROR'),
                    });
                });
        }

        return response.data;
    },
    error => {
        const USER_NOT_FOUND = CONST_AUTH.USER_NOT_FOUND;

        if (USER_NOT_FOUND.code === 404 && error.response.data.code === 404) {
            store.dispatch('user/doLogout')
                .then(() => {
                    router.push('/login');

                    MakeToast({
                        variant: 'danger',
                        title: i18n.t('SESSION_TIMEOUT.TITLE'),
                        content: i18n.t('SESSION_TIMEOUT.MESSAGE'),
                    });
                })
                .catch(() => {
                    MakeToast({
                        variant: 'danger',
                        title: i18n.$t('TOAST.TITLE.ERROR'),
                        content: i18n.t('TOAST.CONTENT.OTHER.ERROR'),
                    });
                });
        }

        return Promise.reject(error);
    }
);

export { service };
