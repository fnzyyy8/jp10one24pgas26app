<script setup lang="ts">
import * as echarts from 'echarts';
import type { EChartsOption, EChartsType } from 'echarts';
import { onMounted, onUnmounted, ref, watch } from 'vue';

interface BarChartData {
    name: string;
    value: number;
    color?: string;
}

interface Props {
    title?: string;
    data: BarChartData[];
    height?: number;
    valueName?: string;
    sortByValue?: boolean;
    horizontal?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    title: '',
    data: () => [],
    height: 300,
    valueName: 'Jumlah',
    sortByValue: false,
    horizontal: false,
});

const chartRef = ref<HTMLDivElement | null>(null);
let chartInstance: EChartsType | null = null;

const updateChart = (): void => {
    if (!chartRef.value) {
return;
}

    chartInstance =
        echarts.getInstanceByDom(chartRef.value) ??
        echarts.init(chartRef.value);

    const chartData = props.sortByValue
        ? [...props.data].sort((a, b) => b.value - a.value)
        : [...props.data];

    const option: EChartsOption = {
        animation: false,

        title: {
            text: props.title,
            left: 'center',
            textStyle: {
                fontSize: 14,
                fontWeight: 'bold',
            },
        },

        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow',
            },
            formatter: (params) => {
                const item = Array.isArray(params) ? params[0] : params;

                return `${item.name}<br/>${props.valueName}: ${item.value}`;
            },
        },

        grid: {
            top: 55,
            left: props.horizontal ? 100 : 40,
            right: 25,
            bottom: props.horizontal ? 20 : 65,
            containLabel: true,
        },

        xAxis: props.horizontal
            ? {
                  type: 'value',
                  min: 0,
                  minInterval: 1,
                  splitLine: {
                      lineStyle: {
                          color: '#e5e7eb',
                          type: 'dashed',
                      },
                  },
              }
            : {
                  type: 'category',
                  data: chartData.map((item) => item.name),
                  axisLabel: {
                      interval: 0,
                      rotate: 25,
                      fontSize: 10,
                  },
                  axisTick: {
                      show: false,
                  },
              },

        yAxis: props.horizontal
            ? {
                  type: 'category',
                  inverse: true,
                  data: chartData.map((item) => item.name),
                  axisTick: {
                      show: false,
                  },
              }
            : {
                  type: 'value',
                  min: 0,
                  minInterval: 1,
                  name: props.valueName,
                  splitLine: {
                      lineStyle: {
                          color: '#e5e7eb',
                          type: 'dashed',
                      },
                  },
              },

        series: [
            {
                name: props.valueName,
                type: 'bar',
                data: chartData.map((item) => ({
                    value: item.value,
                    itemStyle: item.color ? { color: item.color } : undefined,
                })),
                barMaxWidth: 32,
                itemStyle: {
                    color: '#5275E8',
                    borderRadius: props.horizontal
                        ? [0, 4, 4, 0]
                        : [4, 4, 0, 0],
                },
                label: {
                    show: true,
                    position: props.horizontal ? 'right' : 'top',
                    fontSize: 11,
                },
            },
        ],
    };

    chartInstance.setOption(option, true);
};

const handleResize = (): void => {
    chartInstance?.resize();
};

onMounted(() => {
    updateChart();
    window.addEventListener('resize', handleResize);
});

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
    chartInstance?.dispose();
    chartInstance = null;
});

watch(
    () => [
        props.data,
        props.title,
        props.height,
        props.valueName,
        props.sortByValue,
        props.horizontal,
    ],
    () => {
        updateChart();
        chartInstance?.resize();
    },
    { deep: true },
);
</script>

<template>
    <v-card>
        <div class="p-3">
            <div
                ref="chartRef"
                class="w-full"
                :style="{ height: `${props.height}px` }"
            />
        </div>
    </v-card>
</template>
