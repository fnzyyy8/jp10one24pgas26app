<script setup lang="ts">
import * as echarts from 'echarts';
import type { EChartsOption, EChartsType } from 'echarts';
import { onMounted, onUnmounted, ref, watch } from 'vue';

interface ChartDataItem {
    name: string;
    value: number;
    color?: string;
}

interface Props {
    title?: string;
    data: ChartDataItem[];
    height?: string;
}

const props = withDefaults(defineProps<Props>(), {
    title: '',
    data: () => [],
    height: '350px',
});

const chartRef = ref<HTMLElement | null>(null);
let chartInstance: EChartsType | null = null;

const initChart = () => {
    if (!chartRef.value) {
        return;
    }

    chartInstance =
        echarts.getInstanceByDom(chartRef.value) ||
        echarts.init(chartRef.value);

    const formattedData = props.data.map((item) => ({
        name: item.name,
        value: item.value,
        itemStyle: item.color ? { color: item.color } : undefined,
    }));

    const option: EChartsOption = {
        title: {
            text: props.title,
            left: 'center',
            textStyle: { fontSize: 16, fontWeight: 'bold' },
        },
        tooltip: {
            trigger: 'item',
            formatter: '{b} : {c} ({d}%)',
        },
        legend: {
            bottom: '0%',
            left: 'center',
        },
        series: [
            {
                name: props.title,
                type: 'pie',
                radius: ['40%', '70%'],
                avoidLabelOverlap: false,
                itemStyle: {
                    borderRadius: 6,
                    borderColor: '#fff',
                    borderWidth: 2,
                },
                label: {
                    show: false,
                    position: 'center',
                },
                labelLine: {
                    show: true,
                },
                data: formattedData,
            },
        ],
    };
    chartInstance.setOption(option);
};

const handleResize = () => {
    chartInstance?.resize();
};

onMounted(() => {
    initChart();
    window.addEventListener('resize', handleResize);
});

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
    chartInstance?.dispose();
});

watch(
    () => props.data,
    () => {
        initChart();
    },
    { deep: true },
);
</script>

<template>
    <div ref="chartRef" :style="{ width: '100%', height: height }"></div>
</template>

<style scoped></style>
