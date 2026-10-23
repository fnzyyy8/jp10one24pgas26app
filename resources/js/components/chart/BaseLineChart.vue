<script setup lang="ts">
import type { ECharts, EChartsOption } from 'echarts';
import * as echarts from 'echarts';
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { useFormatNumber } from '@/composable/useFormatNumber';

interface ChartData {
    date: string;
    price: number;
}

const props = withDefaults(
    defineProps<{
        data: ChartData[];
        title?: string;
        height?: string | number;
    }>(),
    {
        title: 'Price History',
        height: 300,
    },
);

const chartElement = ref<HTMLElement | null>(null);

let chartInstance: ECharts | null = null;

const { formatDate } = useFormatNumber();

const chartOption = computed<EChartsOption>(() => ({
    tooltip: {
        trigger: 'axis',
        triggerOn: 'mousemove',
        axisPointer: {
            type: 'line',
            snap: false,
        },
        valueFormatter: (value) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0,
            }).format(Number(value));
        },
    },
    grid: {
        left: 60,
        right: 30,
        top: 30,
        bottom: 40,
    },
    xAxis: {
        type: 'category',
        boundaryGap: false,
        data: props.data.map((item) => formatDate(item.date)),
        axisPointer: {
            show: true,
        },
    },
    yAxis: {
        type: 'value',
        axisLabel: {
            formatter: (value: number) => {
                return new Intl.NumberFormat('id-ID', {
                    notation: 'compact',
                    maximumFractionDigits: 1,
                }).format(value);
            },
        },
    },
    series: [
        {
            name: 'Harga',
            type: 'line',
            smooth: false,
            data: props.data.map((item) => [formatDate(item.date), item.price]),
            symbol: 'circle',
            symbolSize: 7,
        },
    ],
}));

const renderChart = () => {
    if (!chartElement.value) {
        return;
    }

    if (!chartInstance) {
        chartInstance = echarts.init(chartElement.value);
    }

    chartInstance.setOption(chartOption.value);
};

const handleResize = () => {
    chartInstance?.resize();
};

watch(
    () => props.data,
    () => renderChart(),
    {
        deep: true,
    },
);

onMounted(() => {
    renderChart();
    window.addEventListener('resize', handleResize);
});

onBeforeUnmount(() => {
    window.removeEventListener('resize', handleResize);

    chartInstance?.dispose();
    chartInstance = null;
});
</script>

<template>
    <v-card>
        <v-card-title>
            {{ title }}
        </v-card-title>
        <v-card-text>
            <div
                ref="chartElement"
                :style="{
                    width: '100%',
                    height: typeof height === 'number' ? `${height}px` : height,
                }"
            />
        </v-card-text>
    </v-card>
</template>

<style scoped></style>
