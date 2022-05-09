import { MakeToast } from '@/utils/MakeToast';
import i18n from '@/lang';

export function validateAddNewTask(DATA = {}) {
    let isPassValidation = false;

    if (DATA.building === null) {
        isPassValidation = false;

        MakeToast({
            variant: 'warning',
            title: i18n.t('TOAST.TITLE.WARNING'),
            content: i18n.t('TOAST.CONTENT.SCHEDULE_MANAGEMENT.REQUIRED_BUILDING'),
        });
    } else if (DATA.task_name === null) {
        isPassValidation = false;

        MakeToast({
            variant: 'warning',
            title: i18n.t('TOAST.TITLE.WARNING'),
            content: i18n.t('TOAST.CONTENT.SCHEDULE_MANAGEMENT.REQUIRED_TASK_NAME'),
        });
    } else if (DATA.date === '') {
        isPassValidation = false;

        MakeToast({
            variant: 'warning',
            title: i18n.t('TOAST.TITLE.WARNING'),
            content: i18n.t('TOAST.CONTENT.SCHEDULE_MANAGEMENT.REQUIRED_START_DATE'),
        });
    } else if (DATA.start_time === '') {
        isPassValidation = false;

        MakeToast({
            variant: 'warning',
            title: i18n.t('TOAST.TITLE.WARNING'),
            content: i18n.t('TOAST.CONTENT.SCHEDULE_MANAGEMENT.REQUIRED_START_TIME'),
        });
    } else if (DATA.end_time === '') {
        isPassValidation = false;

        MakeToast({
            variant: 'warning',
            title: i18n.t('TOAST.TITLE.WARNING'),
            content: i18n.t('TOAST.CONTENT.SCHEDULE_MANAGEMENT.REQUIRED_END_TIME'),
        });
    } else {
        isPassValidation = true;
    }

    return isPassValidation;
}
