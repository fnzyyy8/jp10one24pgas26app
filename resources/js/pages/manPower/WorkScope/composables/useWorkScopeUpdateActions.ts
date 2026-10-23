import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import type { WorkScope } from '@/pages/manPower/WorkScope/types';
import { route } from 'ziggy-js';

export function useWorkScopeUpdateActions(onSuccess?: () => void) {
    const dialog = ref(false);
    const currentId = ref<number | null>(null);
    const loading = ref(false);

    const form = useForm({
        name: '',
    });

    const openEditModal = (id: number, workScope: WorkScope) => {
        currentId.value = id;
        form.name = workScope.name;
        dialog.value = true;
    };

    const submitForm = () => {
        if (!currentId.value) {
return;
}

        loading.value = true;
        form.put(route('work-scope.update', currentId.value), {
            preserveScroll: true,
            onSuccess: () => {
                dialog.value = false;
                form.reset();

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
        loading,
        openEditModal,
        submitForm,
    };
}
