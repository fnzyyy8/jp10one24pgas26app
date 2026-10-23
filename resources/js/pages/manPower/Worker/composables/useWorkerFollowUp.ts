import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { route } from 'ziggy-js';

export function useWorkerFollowUp() {
    const isConfirmOpen = ref(false);
    const isLoading = ref(false);
    const selectedWorkerId = ref<number | null>(null);
    const selectedWorkerName = ref<string | null>(null);

    const openConfirm = (workerId: number, workerName: string) => {
        if (isLoading.value) {
            return;
        }

        selectedWorkerId.value = workerId;
        selectedWorkerName.value = workerName;
        isConfirmOpen.value = true;
    };

    const cancelConfirm = () => {
        if (isLoading.value) {
            return;
        }

        isConfirmOpen.value = false;
        selectedWorkerId.value = null;
        selectedWorkerName.value = null;
    };

    const confirmFollowUp = () => {
        const workerId = selectedWorkerId.value;

        if (workerId === null || isLoading.value) {
            return;
        }

        isLoading.value = true;

        router.patch(
            route('worker.follow-up', workerId),
            {},
            {
                preserveScroll: true,

                onFinish: () => {
                    isLoading.value = false;
                    isConfirmOpen.value = false;
                    selectedWorkerId.value = null;
                    selectedWorkerName.value = null;
                },
            },
        );
    };

    return {
        isConfirmOpen,
        isLoading,
        selectedWorkerId,
        selectedWorkerName,
        openConfirm,
        cancelConfirm,
        confirmFollowUp,
    };
}
