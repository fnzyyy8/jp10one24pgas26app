import { useForm } from '@inertiajs/vue3';
import type { MaybeRefOrGetter } from 'vue';
import { toValue } from 'vue';
import { ref } from 'vue';
import type { Boq } from '@/pages/projectControl/PlanDetail/Types/plan.detail';
import { route } from 'ziggy-js';

export function usePlanDetailActions(boq: MaybeRefOrGetter<Boq>) {
    const isCreateOpen = ref(false);
    const date = ref<Date | null>(null);

    const formDelete = useForm({});
    const form = useForm({
        plan_id: toValue(boq).planId,
        volume: 1,
        plan_date: '',
    });
    const openCreateDialog = () => {
        isCreateOpen.value = true;
    };

    const submitCreate = () => {
        form.plan_date = date.value
            ? date.value.toLocaleDateString('en-CA')
            : '';

        console.log(form.data());
        form.post(
            route('plan.detail.create', {
                boq: toValue(boq).id,
                plan: toValue(boq).planId,
            }),
            {
                preserveScroll: true,
                onSuccess: () => {
                    form.reset();
                    date.value = null;
                    isCreateOpen.value = false;
                },
                onError: (e) => {
                    console.log(e);
                },
            },
        );
    };

    const submitDelete = (id: number) => {
        console.log(toValue(boq).id);
        formDelete.delete(
            route('plan.detail.delete', {
                boq: toValue(boq).id,
                id: id,
            }),
            {
                preserveScroll: true,
            },
        );
    };

    return {
        form,
        date,
        isCreateOpen,
        loading: form.processing,
        openCreateDialog,
        submitCreate,
        submitDelete,
    };
}
