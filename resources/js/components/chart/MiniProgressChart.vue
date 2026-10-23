<script setup lang="ts">
import type { ECharts, EChartsOption } from 'echarts';
import * as echarts from 'echarts';
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';

interface Props {
    value: number;
    width?: string | number;
    height?: string | number;
    showLabel?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    value: 0,
    width: 140,
    height: 24,
    showLabel: false,
});

const chartElement = ref<HTMLElement | null>(null);

let chartInstance: ECharts | null = null;

const chartValue = computed(() => {
    return Math.min(Math.max(props.value, 0), 100);
});

const chartOption = computed<EChartsOption>(() => ({
    grid: {
        left: 0,
        right: props.showLabel ? 35 : 0,
        top: 0,
        bottom: 0,
    },

    xAxis: {
        type: 'value',
        min: 0,
        max: 100,
        show: false,
    },

    yAxis: {
        type: 'category',
        data: ['Progress'],
        show: false,
    },

    series: [
        {
            type: 'bar',
            data: [chartValue.value],
            barWidth: 8,

            showBackground: true,

            backgroundStyle: {
                color: '#e5e7eb',
                borderRadius: 10,
            },

            itemStyle: {
                borderRadius: 10,
            },

            label: props.showLabel
                ? {
                      show: true,
                      position: 'right',
                      distance: 4,
                      formatter: `${chartValue.value}%`,
                      fontSize: 12,
                  }
                : {
                      show: false,
                  },

            emphasis: {
                disabled: true,
            },
        },
    ],

    tooltip: {
        trigger: 'item',
        formatter: `${chartValue.value}%`,
    },
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
    () => props.value,
    () => renderChart(),
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
    <div
        ref="chartElement"
        :style="{
            width:
                typeof props.width === 'number'
                    ? `${props.width}px`
                    : props.width,
            height:
                typeof props.height === 'number'
                    ? `${props.height}px`
                    : props.height,
        }"
    />
</template>

<style scoped></style>
