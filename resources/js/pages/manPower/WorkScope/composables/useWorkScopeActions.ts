import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { route } from 'ziggy-js';

export function useWorkScopeActions() {
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
        if (selectedId.value === null) {
            return;
        }

        deleteLoading.value = true;

        router.delete(route('work-scope.delete', selectedId.value), {
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
