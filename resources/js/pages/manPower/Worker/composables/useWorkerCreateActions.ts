import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { route } from 'ziggy-js';

interface WorkerForm {
    id_card_number: string;
    name: string;
    based: string;
    phone_number: string;
    email: string;
    work_status: string;
    last_follow_up: string;
    work_scope_ids: number[];
}
export function useWorkerCreateActions(onSuccess?: () => void) {
    const loading = ref(false);
    const lastFollowUpDate = ref<Date | null>(null);

    const form = useForm<WorkerForm>({
        id_card_number: '',
        name: '',
        based: '',
        phone_number: '',
        email: '',
        work_status: 'active',
        last_follow_up: '',
        work_scope_ids: [],
    });

    const submitForm = () => {
        if (loading.value) {
            return;
        }

        form.last_follow_up = lastFollowUpDate.value
            ? lastFollowUpDate.value.toLocaleDateString('en-CA')
            : '';

        loading.value = true;

        form.post(route('worker.create'), {
            preserveScroll: true,

            onSuccess: () => {
                form.reset();
                lastFollowUpDate.value = null;
                form.clearErrors();
                onSuccess?.();
            },

            onFinish: () => {
                loading.value = false;
            },
        });
    };

    return {
        form,
        lastFollowUpDate,
        submitForm,
        loading,
    };
}
