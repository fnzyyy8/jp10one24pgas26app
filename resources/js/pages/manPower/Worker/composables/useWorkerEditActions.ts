import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import type { Worker } from '@/pages/manPower/Worker/types';
import { route } from 'ziggy-js';

export function useWorkerEditActions(worker: Worker) {
    const loading = ref(false);
    const lastFollowUpDate = ref<Date | null>(
        worker.last_follow_up ? new Date(worker.last_follow_up) : null,
    );

    const form = useForm({
        id_card_number: worker.id_card_number || '',
        name: worker.name || '',
        based: worker.based || '',
        phone_number: worker.phone_number || '',
        email: worker.email || '',
        work_status: worker.work_status || 'active',
        last_follow_up: worker.last_follow_up || '',
        work_scope_ids: worker.work_scopes?.map((s) => s.id) || ([] as number[]),
        photo: null as File | null,
    });

    const submitForm = () => {
        if (loading.value) {
return;
}

        form.last_follow_up = lastFollowUpDate.value
            ? lastFollowUpDate.value.toLocaleDateString('en-CA')
            : '';

        loading.value = true;

        form.post(route('worker.update', worker.id), {
            preserveScroll: true,
            onFinish: () => {
                loading.value = false;
            },
        });
    };

    return {
        form,
        lastFollowUpDate,
        loading,
        submitForm,
    };
}
