import { router, useForm } from '@inertiajs/vue3';
import { ref, toValue } from 'vue';
import type { MaybeRefOrGetter } from 'vue';
import type { Boq, Plan } from '@/pages/projectControl/Plan/Types/plan.type';
import { route } from 'ziggy-js';

export function usePlanActions(boq: MaybeRefOrGetter<Boq>) {
    const isVolumeCreateOpen = ref(false);
    const selectedPlan = ref<Plan | null>(null);

    const volumeForm = useForm({
        volume: null as number | null,
    });

    const routeToUpdatePlan = (id: number) => {
        router.visit(
            route('plan.updatePlan', {
                boq: id,
            }),
        );
    };

    const routeToPlanDetail = (plan: Plan) => {
        router.visit(
            route('plan.detail.index', {
                boq: toValue(boq).id,
                plan: plan.id,
            }),
        );
    };

    const handleOpenVolume = (plan: Plan) => {
        selectedPlan.value = plan;
        volumeForm.volume = plan.volume === null ? null : Number(plan.volume);
        isVolumeCreateOpen.value = true;
    };

    const submitVolume = () => {
        if (!selectedPlan.value) {
            return;
        }

        volumeForm.put(
            route('plan.update', {
                boq: toValue(boq).id,
                plan: selectedPlan.value.id,
            }),
            {
                preserveScroll: true,
                onSuccess: () => {
                    volumeForm.reset();

                    selectedPlan.value = null;
                    isVolumeCreateOpen.value = false;
                },
                onError: (e) => {
                    console.log(e);
                },
            },
        );
    };

    return {
        volumeForm,
        isVolumeCreateOpen,
        selectedPlan,
        routeToUpdatePlan,
        routeToPlanDetail,
        handleOpenVolume,
        submitVolume,
    };
}
