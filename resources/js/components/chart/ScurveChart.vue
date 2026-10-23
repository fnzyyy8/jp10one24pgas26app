<script setup lang="ts">
import * as echarts from 'echarts';
import type { EChartsOption, EChartsType } from 'echarts';
import { onMounted, onUnmounted, ref, toRef, watch } from 'vue';
import { useSCurve } from '@/composable/Chart/useSCurve';
import type { PeriodFilter, SCurveData } from '@/composable/Chart/useSCurve';

interface Props {
    title?: string;
    data: SCurveData[];
    height?: number;
}

const props = withDefaults(defineProps<Props>(), {
    title: 'S Curve',
    data: () => [],
    height: 300,
});

const selectedPeriod = ref<PeriodFilter>('weekly');

const periodOptions = [
    { label: 'Harian', value: 'daily' },
    { label: 'Mingguan', value: 'weekly' },
];

const chartRef = ref<HTMLDivElement | null>(null);
let chartInstance: EChartsType | null = null;

const { chartData } = useSCurve(toRef(props, 'data'), selectedPeriod);

const updateChart = (): void => {
    if (!chartRef.value) {
        return;
    }

    const data = chartData.value;

    chartInstance =
        echarts.getInstanceByDom(chartRef.value) ||
        echarts.init(chartRef.value);

    const option: EChartsOption = {
        animation: false,
        tooltip: {
            trigger: 'axis',
            valueFormatter: (value) => (value == null ? '-' : `${value}%`),
        },
        legend: {
            bottom: 10,
            right: 0,
            data: ['Plan', 'Actual', 'Forecast'],
        },
        grid: {
            top: 30,
            bottom: 75,
            left: 12,
            right: 25,
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: data.map((item) => item.date),
            axisLabel: {
                formatter: (_value: string, index: number) =>
                    data[index]?.periodLabel ?? '',
                margin: 12,
            },
        },
        yAxis: {
            type: 'value',
            min: 0,
            max: 100,
            axisLabel: {
                formatter: `{value}%`,
            },
        },

        series: [
            {
                name: 'Plan',
                type: 'line',
                data: data.map((item) => item.plan),
                smooth: true,
                showSymbol: false,
                lineStyle: {
                    width: 2,
                    type: 'dashed',
                },
            },
            {
                name: 'Actual',
                type: 'line',
                data: data.map((item) => item.actual),
                smooth: true,
                connectNulls: false,
                showSymbol: false,
                lineStyle: {
                    width: 3,
                },
            },
            {
                name: 'Forecast',
                type: 'line',
                data: data.map((item) => item.forecast),
                smooth: true,
                connectNulls: false,
                showSymbol: false,
                lineStyle: {
                    width: 2,
                    type: 'dotted',
                },
            },
        ],
    };

    chartInstance.setOption(option, true);
};

const handleResize = () => {
    chartInstance?.resize();
};

onMounted(() => {
    if (!chartRef.value) {
        return;
    }

    chartInstance = echarts.init(chartRef.value);

    updateChart();

    window.addEventListener('resize', handleResize);
});

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);

    chartInstance?.dispose();
    chartInstance = null;
});

watch([chartData, () => props.title], updateChart);

watch(
    () => props.height,
    () => chartInstance?.resize(),
);
</script>

<template>
    <v-card>
        <div class="p-3">
            <div class="grid grid-cols-3">
                <h1>S Curve</h1>
                <v-select
                    v-model="selectedPeriod"
                    :items="periodOptions"
                    density="compact"
                    item-title="label"
                    item-value="value"
                    label="Periode"
                    hide-details
                    class="col-start-3"
                />
            </div>
            <div
                class="w-full"
                :style="{ height: `${props.height}px` }"
                ref="chartRef"
            />
        </div>
    </v-card>
</template>

<style scoped></style>
