<script setup lang="ts">
import { onMounted } from 'vue';
import BarChart from '@/components/chart/BarChart.vue';
import ScurveChart from '@/components/chart/ScurveChart.vue';
import { useBreadcrumb } from '@/composable/useBreadcrumb';
import ProgressInformation from '@/pages/projectControl/Progress/Components/ProgressInformation.vue';
import {
    barChart,
    dataDummy,
} from '@/pages/projectControl/Progress/Dummy/dummy';
import type { Boq } from '@/pages/projectControl/Progress/Types/progress.types';
import { route } from 'ziggy-js';

defineProps<{
    boq: Boq;
}>();
const { setBreadcrumbs } = useBreadcrumb();

onMounted(() =>
    setBreadcrumbs([
        {
            title: 'BOQ',
            href: route('boq'),
        },
        {
            title: 'PROGRESS',
            disabled: true,
        },
    ]),
);
</script>

<template>
    <div class="flex flex-col gap-3">
        <ProgressInformation :boq="boq" />
        <div class="grid grid-cols-3 gap-3">
            <div class="col-span-2">
                <ScurveChart :data="dataDummy" />
            </div>
            <BarChart :data="barChart" />
        </div>
    </div>
</template>

<style scoped></style>
