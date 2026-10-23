import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import type { Worker } from '@/pages/manPower/Worker/types';
import { route } from 'ziggy-js';

export function useWorkerUpdateActions(onSuccess?: () => void) {
    const dialog = ref(false);
    const currentId = ref<number | null>(null);
    const loading = ref(false);
    const lastFollowUpDate = ref<Date | null>(null);

    const form = useForm({
        id_card_number: '',
        name: '',
        based: '',
        phone_number: '',
        email: '',
        work_status: 'active',
        last_follow_up: '',
        work_scope_ids: [] as number[],
    });

    const openEditModal = (id: number, worker: Worker) => {
        currentId.value = id;
        form.id_card_number = worker.id_card_number;
        form.name = worker.name;
        form.based = worker.based;
        form.phone_number = worker.phone_number;
        form.email = worker.email;
        form.work_status = worker.work_status;
        form.last_follow_up = worker.last_follow_up;
        lastFollowUpDate.value = worker.last_follow_up ? new Date(worker.last_follow_up) : null;
        form.work_scope_ids = worker.work_scopes?.map((s) => s.id) || [];
        dialog.value = true;
    };

    const submitForm = () => {
        if (!currentId.value) {
return;
}

        form.last_follow_up = lastFollowUpDate.value
            ? lastFollowUpDate.value.toLocaleDateString('en-CA')
            : '';

        loading.value = true;
        form.put(route('worker.update', currentId.value), {
            preserveScroll: true,
            onSuccess: () => {
                dialog.value = false;
                form.reset();
                lastFollowUpDate.value = null;

                if (onSuccess) {
onSuccess();
}
            },
            onFinish: () => {
                loading.value = false;
            },
        });
    };

    return {
        dialog,
        form,
        lastFollowUpDate,
        loading,
        openEditModal,
        submitForm,
    };
}
