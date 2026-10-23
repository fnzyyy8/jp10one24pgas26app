import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { route } from 'ziggy-js';

export function useWorkerActions() {
    const isCreateOpen = ref(false);
    const isDeleteOpen = ref(false);
    const deleteLoading = ref(false);
    const selectedId = ref<number | null>(null);

    const openCreateModal = () => {
        isCreateOpen.value = true;
    };

    const openDeleteModal = (id: number) => {
        selectedId.value = id;
        isDeleteOpen.value = true;
    };

    const confirmDeleteModal = () => {
        if (!selectedId.value) {
return;
}

        deleteLoading.value = true;
        router.delete(route('worker.delete', selectedId.value), {
            preserveScroll: true,
            onFinish: () => {
                deleteLoading.value = false;
                isDeleteOpen.value = false;
                selectedId.value = null;
            },
        });
    };

    return {
        isCreateOpen,
        isDeleteOpen,
        deleteLoading,
        openCreateModal,
        openDeleteModal,
        confirmDeleteModal,
    };
}
