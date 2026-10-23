<script setup lang="ts">
import { onMounted } from 'vue';
import AppCard from '@/components/card/AppCard.vue';
import { useBreadcrumb } from '@/composable/useBreadcrumb';

import PlanVolumeForm from '@/pages/projectControl/Plan/Components/Form/PlanVolumeForm.vue';
import PlanTableV2 from '@/pages/projectControl/Plan/Components/Table/PlanTableV2.vue';
import { usePlanActions } from '@/pages/projectControl/Plan/Composables/usePlanActions';
import type {
    Boq,
    Plan,
    PlanSection,
} from '@/pages/projectControl/Plan/Types/plan.type';
import { route } from 'ziggy-js';

const props = defineProps<{
    boq: Boq;
    planSections: PlanSection[];
    plans: Plan[];
}>();

const { setBreadcrumbs } = useBreadcrumb();

onMounted(() => {
    setBreadcrumbs([
        {
            title: 'BOQ',
            href: route('boq'),
        },
        {
            title: 'PLAN',
            disabled: true,
        },
    ]);
});

const {
    volumeForm,
    isVolumeCreateOpen,
    selectedPlan,
    routeToUpdatePlan,
    routeToPlanDetail,
    handleOpenVolume,
    submitVolume,
} = usePlanActions(() => props.boq);
</script>

<template>
    <PlanVolumeForm
        v-model:volume="volumeForm.volume"
        :plan="selectedPlan"
        v-model="isVolumeCreateOpen"
        @submit-volume="submitVolume"
    />
    <div class="flex flex-col gap-3">

        <AppCard
            :multipleActions="true"
            :active-actions="['update']"
            @update="routeToUpdatePlan(props.boq.id)"
        >
            <div>
                <div class="">
                    <div class="mb-3 flex flex-col">
                        <div>
                            <span>Nama Proyek</span>
                            <h1>{{ boq.project_name }}</h1>
                        </div>
                    </div>
                    <div class="flex gap-5">
                        <div>
                            <span>Nomor SPK</span>
                            <h3>{{ boq.project_number }}</h3>
                        </div>
                        <v-divider vertical />
                        <div>
                            <span>Client</span>
                            <h3>{{ boq.client }}</h3>
                        </div>
                        <v-divider vertical />
                        <div>
                            <span>Area</span>
                            <h3>{{ boq.area }}</h3>
                        </div>
                        <v-divider vertical />
                        <div>
                            <span>Detail Area</span>
                            <h3>{{ boq.detailed_area }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </AppCard>
<!--        <PlanTable-->
<!--            :planSections="planSections"-->
<!--            @open-volume="handleOpenVolume"-->
<!--            @open-plan-detail="routeToPlanDetail"-->
<!--        />-->
        <PlanTableV2
            :plans="plans"
            @open-volume="handleOpenVolume"
            @open-plan-detail="routeToPlanDetail"
        />
    </div>
</template>

<style scoped></style>
