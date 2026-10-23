<script setup lang="ts">
import { computed } from 'vue';
import { useDistributeDate } from '@/pages/projectControl/PlanDetail/Composables/useDistributeDate';
import type {
    Boq,
    ItemDetail,
    PlanDetail,
} from '@/pages/projectControl/PlanDetail/Types/plan.detail';

const props = defineProps<{
    boq: Boq;
    planDetails: PlanDetail[];
    itemDetail: ItemDetail;
}>();

const { monthYearGroup, dateList } = useDistributeDate(
    () => props.boq.startDate,
    () => props.boq.endDate,
);

const volumeByDate = computed(() => {
    return new Map(
        props.planDetails
            .filter((detail) => detail.date)
            .map((detail) => [detail.date, detail.volume]),
    );
});

const fixedColumns = [
    { key: 'name', title: 'Judul Pekerjaan' },
    { key: 'volume', title: 'Volume' },
    { key: 'totalVolume', title: 'Total Volume' },
] as const;
</script>

<template>
    <v-card flat border>
        <div class="p-3">
            <v-table class="plan-detail-table">
                <thead>
                    <tr>
                        <th
                            v-for="(column, index) in fixedColumns"
                            :key="column.key"
                            rowspan="2"
                            class="sticky-col border text-left"
                            :class="`col-${index + 1}`"
                        >
                            {{ column.title }}
                        </th>
                        <th
                            v-for="group in monthYearGroup"
                            :key="group.monthYear"
                            :colspan="group.count"
                            class="border text-center"
                        >
                            {{ group.monthYear }}
                        </th>
                    </tr>
                    <tr>
                        <template v-for="group in monthYearGroup">
                            <th
                                v-for="date in group.dates"
                                :key="date"
                                class="day-col border text-center"
                            >
                                {{ Number(date.split('-')[2]) }}
                            </th>
                        </template>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="sticky-col col-1 border">Rencana</td>
                        <td class="sticky-col col-2 border">
                            {{ props.itemDetail.volume ?? '-' }}
                        </td>
                        <td class="sticky-col col-3 border">
                            {{ props.itemDetail.totalVolume ?? '-' }}
                        </td>
                        <td
                            v-for="date in dateList"
                            :key="date"
                            class="border text-center"
                        >
                            {{ volumeByDate.get(date) ?? '-' }}
                        </td>
                    </tr>
                </tbody>
            </v-table>
        </div>
    </v-card>
</template>

<style scoped>
.plan-detail-table {
    overflow: auto;
}

:deep(.v-table__wrapper) {
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* Internet Explorer dan Edge lama */
}

:deep(.v-table__wrapper::-webkit-scrollbar) {
    display: none; /* Chrome, Safari, Opera, dan Edge */
}

.sticky-col {
    position: sticky !important;
    z-index: 2;
    background-color: #ffffff !important;
    background-clip: padding-box;
}

th.sticky-col {
    z-index: 3;
}

.col-1 {
    left: 0;
    min-width: 200px;
    width: 200px;
}

.col-2 {
    left: 200px;
    min-width: 200px;
    width: 200px;
}

.col-3 {
    left: 400px;
    min-width: 200px;
    width: 200px;
    box-shadow: 2px 0 5px -2px rgba(0, 0, 0, 0.1);
}

.day-col {
    min-width: 45px;
}
</style>
