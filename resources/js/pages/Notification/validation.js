import { MakeToast } from '@/utils/MakeToast';
import i18n from '@/lang';

export function validation(DATA = {}) {
    let total_size = 0;
    let is_valid = false;
    const maxSize = 68157440;

    if (DATA) {
        for (let i = 0; i < DATA.files.length; i++) {
            total_size += DATA.files[i].size;
        }

        if (DATA.subject.length === 0) {
            MakeToast({
                variant: 'warning',
                title: i18n.t('TOAST.TITLE.WARNING'),
                content: i18n.t('TOAST.CONTENT.NOTIFICATION.REQUIRE_SUBJECT'),
            });
        } else if (DATA.content.length === 0) {
            MakeToast({
                variant: 'warning',
                title: i18n.t('TOAST.TITLE.WARNING'),
                content: i18n.t('TOAST.CONTENT.NOTIFICATION.REQUIRED_CONTENT'),
            });
        } else if (total_size > maxSize) {
            MakeToast({
                variant: 'warning',
                title: i18n.t('TOAST.TITLE.WARNING'),
                content: i18n.t('TOAST.CONTENT.NOTIFICATION.FILE_SIZE_VALIDATION'),
            });
        } else {
            is_valid = true;
            return is_valid;
        }
    } else {
        return is_valid;
    }
}
