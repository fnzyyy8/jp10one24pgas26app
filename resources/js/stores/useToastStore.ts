import { defineStore } from 'pinia';
import { ref } from 'vue';

export type ToastType = 'success' | 'error' | 'info' | 'warning';
export const useToastStore = defineStore('toast', () => {
    const visible = ref(false);
    const message = ref('');
    const type = ref<ToastType>('success');

    let timer: ReturnType<typeof setTimeout> | null = null;

    const show = (
        msg: string,
        toastType: ToastType = 'success',
        duration = 3000,
    ) => {
        if (timer) {
            clearTimeout(timer);
        }

        message.value = msg;
        type.value = toastType;
        visible.value = true;

        timer = setTimeout(() => {
            visible.value = false;
        }, duration);
    };

    const success = (msg: string) => show(msg, 'success');
    const error = (msg: string) => show(msg, 'error');

    const info = (msg: string) => show(msg, 'info');
    const hide = () => {
        visible.value = false;
    };

    return {
        visible,
        message,
        type,
        show,
        success,
        error,
        info,
        hide,
    };
});
