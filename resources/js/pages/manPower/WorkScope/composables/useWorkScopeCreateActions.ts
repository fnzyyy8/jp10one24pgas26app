import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { route } from 'ziggy-js';

export function useWorkScopeCreateActions(onSuccessCallback?: () => void) {
    const loading = ref(false);
    const form = useForm({
        name: '',
    });

    const submitForm = () => {
        loading.value = true;
        form.post(route('work-scope.create'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();

                if (onSuccessCallback) {
                    onSuccessCallback();
                }
            },
            onFinish: () => {
                loading.value = false;
            },
        });
    };

    return {
        form,
        submitForm,
        loading,
    };
}
