<script setup lang="ts">
import { onMounted } from 'vue';
import { useBreadcrumb } from '@/composable/useBreadcrumb';
import PlanDetailForm from '@/pages/projectControl/PlanDetail/Components/Form/PlanDetailForm.vue';
import PlanDetailInformation from '@/pages/projectControl/PlanDetail/Components/PlanDetailInformation.vue';
import PlanDetailGridTableV2 from '@/pages/projectControl/PlanDetail/Components/Table/PlanDetailGridTableV2.vue';
import PlanDetailTable from '@/pages/projectControl/PlanDetail/Components/Table/PlanDetailTable.vue';
import { usePlanDetailActions } from '@/pages/projectControl/PlanDetail/Composables/usePlanDetailActions';
import type {
    Boq,
    ItemDetail,
    PlanDetail,
} from '@/pages/projectControl/PlanDetail/Types/plan.detail';
import { route } from 'ziggy-js';

const props = defineProps<{
    boq: Boq;
    itemDetail: ItemDetail;
    planDetails: PlanDetail[];
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
            href: route('plan.index', props.boq.id),
        },
        {
            title: 'PLAN DETAIL',
            disabled: true,
        },
    ]);
});

const {
    isCreateOpen,
    form,
    date,
    loading,
    submitCreate,
    openCreateDialog,
    submitDelete,
} = usePlanDetailActions(() => props.boq);
</script>
<template>
    <PlanDetailForm
        v-model="isCreateOpen"
        :boq="boq"
        v-model:volume="form.volume"
        v-model:date="date"
        :loading="loading"
        @submit-create="submitCreate"
    />
    <div class="flex flex-col gap-3">
        <PlanDetailInformation :boq="boq" :itemDetail="itemDetail" />
        <PlanDetailGridTableV2
            :boq="boq"
            :plan-details="planDetails"
            :item-detail="itemDetail"
        />
<!--        <PlanGridTable-->
<!--            :boq="boq"-->
<!--            :itemDetail="itemDetail"-->
<!--            :planDetails="planDetails"-->
<!--        />-->
        <PlanDetailTable
            :itemDetail="itemDetail"
            :planDetails="planDetails"
            @open-create="openCreateDialog"
            @delete="(id) => submitDelete(id)"
        />
    </div>
</template>

<style scoped></style>
