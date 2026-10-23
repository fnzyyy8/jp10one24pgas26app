<script setup lang="ts">
import { themeQuartz } from 'ag-grid-community';
import { AgGridVue } from 'ag-grid-vue3';
import { computed } from 'vue';

import { useDistributeDate } from '@/pages/projectControl/PlanDetail/Composables/useDistributeDate';
import { usePlanDetailGrid } from '@/pages/projectControl/PlanDetail/Composables/usePlanDetailGrid';
import type {
    Boq,
    ItemDetail,
    PlanDetail,
} from '@/pages/projectControl/PlanDetail/Types/plan.detail';
import { createPlanDetailRow } from '@/pages/projectControl/PlanDetail/Utils/planDetailGrid.utils';

interface Props {
    boq: Boq;
    planDetails: PlanDetail[];
    itemDetail: ItemDetail;
}

const props = defineProps<Props>();

const { monthYearGroup, dateList } = useDistributeDate(
    () => props.boq.startDate,
    () => props.boq.endDate,
);

const { columnDefs, defaultColDef } = usePlanDetailGrid(monthYearGroup);

const rowData = computed(() => [
    createPlanDetailRow(
        props.itemDetail.volume,
        props.itemDetail.totalVolume,
        props.planDetails,
        dateList.value,
    ),
]);
</script>

<template>
    <v-card>
        <div class="plan-grid p-3">
            <AgGridVue
                :theme="themeQuartz"
                :rowData="rowData"
                :columnDefs="columnDefs"
                :defaultColDef="defaultColDef"
                :headerHeight="40"
                :groupHeaderHeight="40"
                :rowHeight="44"
                :animateRows="false"
                domLayout="autoHeight"
                style="width: 100%"
            />
        </div>
    </v-card>
</template>

<style scoped>
.plan-grid {
    width: 100%;
    min-width: 0;
}

/* Sembunyikan scrollbar AG Grid */
.plan-grid :deep(.ag-body-horizontal-scroll),
.plan-grid :deep(.ag-body-vertical-scroll) {
    display: none !important;
}

/* Sembunyikan scrollbar native jika masih muncul */
.plan-grid :deep(.ag-body-viewport),
.plan-grid :deep(.ag-center-cols-viewport) {
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.plan-grid :deep(.ag-body-viewport::-webkit-scrollbar),
.plan-grid :deep(.ag-center-cols-viewport::-webkit-scrollbar) {
    display: none;
    width: 0;
    height: 0;
}
</style>
