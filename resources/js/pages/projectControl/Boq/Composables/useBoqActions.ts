import { router, useForm } from '@inertiajs/vue3';

import { ref } from 'vue';

import type { Boq } from '@/pages/projectControl/Boq/Types/boq.type';

import { route } from 'ziggy-js';

const isCreateOpen = ref(false);
const isUpdateOpen = ref(false);
const selectedBoq = ref<Boq | null>(null);
export function useBoqActions() {
    // Create
    const openCreateDialog = () => {
        isCreateOpen.value = true;
    };

    // Update
    const openUpdateDialog = (boq: Boq) => {
        selectedBoq.value = boq;
        isUpdateOpen.value = true;
    };

    // Delete
    const formDelete = useForm({});

    const submitDeleteForm = (id: number) => {
        formDelete.delete(route('boq.delete', id));
    };

    const viewPlan = (id: number) => {
        router.visit(route('plan.index', id));
    };

    const viewProgress = (id: number) => {
        router.visit(route('progress.index', id));
    };

    return {
        selectedBoq,
        isCreateOpen,
        isUpdateOpen,
        viewProgress,
        viewPlan,
        openCreateDialog,
        openUpdateDialog,
        submitDeleteForm,
    };
}
