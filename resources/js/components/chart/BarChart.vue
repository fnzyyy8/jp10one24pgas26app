<script setup lang="ts">
import * as echarts from 'echarts';
import type { EChartsOption, EChartsType } from 'echarts';
import { onMounted, onUnmounted, ref, watch } from 'vue';
interface ProgressData {
    name: string;
    progress: number;
}
interface Props {
    title?: string;
    data: ProgressData[];
    height?: number;
}

const props = withDefaults(defineProps<Props>(), {
    title: 'Progress Pekerjaan',
    data: () => [],
    height: 300,
});

const chartRef = ref<HTMLDivElement | null>(null);
let chartInstance: EChartsType | null = null;

const updateChart = (): void => {
    if (!chartRef.value) {
        return;
    }

    const data = [...props.data].sort((a, b) => b.progress - a.progress);

    chartInstance =
        echarts.getInstanceByDom(chartRef.value) ||
        echarts.init(chartRef.value);

    const option: EChartsOption = {
        animation: false,
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow',
            },
            formatter: (params) => {
                const item = Array.isArray(params) ? params[0] : params;

                return `${item.name}<br/>Progress: ${item.value}%`;
            },
        },
        legend: {
            top: 28,
            right: 0,
            data: ['Plan', 'Actual', 'Forecast'],
        },
        grid: {
            top: 20,
            left: 12,
            right: 35,
            bottom: 12,
        },
        xAxis: {
            type: 'value',
            min: 0,
            max: 100,
            axisLabel: {
                formatter: '{value}%',
            },
            splitLine: {
                lineStyle: {
                    type: 'dashed',
                    color: '#e5e7eb',
                },
            },
        },
        yAxis: {
            type: 'category',
            inverse: true,
            data: data.map((item) => item.name),
            axisTick: {
                show: false,
            },
            axisLine: {
                show: false,
            },
        },

        series: [
            {
                name: 'Progress',
                type: 'bar',
                data: data.map((item) => item.progress),
                barWidth: 18,
                showBackground: true,
                backgroundStyle: {
                    color: '#f1f5f9',
                    borderRadius: 4,
                },
                itemStyle: {
                    borderRadius: [0, 4, 4, 0],
                    color: '#4f7cff',
                },
                label: {
                    show: true,
                    position: 'right',
                    formatter: '{c}%',
                    color: '375151',
                    fontSize: 12,
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

watch([props.data, () => props.title], updateChart, { deep: true });

watch(
    () => props.height,
    () => chartInstance?.resize(),
);
</script>

<template>
    <v-card>
        <div class="p-3">
            <h1>Progress</h1>
            <div
                class="w-full"
                :style="{ height: `${props.height}px` }"
                ref="chartRef"
            />
        </div>
    </v-card>
</template>

<style scoped></style>
