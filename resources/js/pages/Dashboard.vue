<script setup lang="ts">
import { onMounted } from 'vue';
import DoughnutChart from '@/components/chart/DoughnutChart.vue';
import { useBreadcrumb } from '@/composable/useBreadcrumb';

interface StatusChartData {
    name: string;
    value: number;
    color?: string;
}

defineProps<{
    page_title: string;
    project_statuses: StatusChartData[];
}>();

const { clearBreadcrumbs } = useBreadcrumb();

onMounted(() => clearBreadcrumbs());
</script>

<template>
    <div class="grid grid-flow-row grid-cols-4 gap-3">
        <div class="col-span-1">
            <v-card min-height="450">
                <v-card-title class="min-h-20">
                    <h4>PROJECT STATUS</h4>
                </v-card-title>
                <v-card-text>
                    <DoughnutChart
                        v-if="project_statuses && project_statuses.length > 0"
                        :data="project_statuses"
                    />
                </v-card-text>
            </v-card>
        </div>
        <div class="col-span-3">
            <v-card min-height="450">
                <v-card-title class="min-h-20">
                    <div class="flex justify-between">
                        <h4>PROJECT MONITORING</h4>
                        <v-select
                            label="Pilih Proyek"
                            density="compact"
                            max-width="400"
                            variant="outlined"
                        />
                    </div>
                </v-card-title>
            </v-card>
        </div>
    </div>
</template>

<style scoped></style>
