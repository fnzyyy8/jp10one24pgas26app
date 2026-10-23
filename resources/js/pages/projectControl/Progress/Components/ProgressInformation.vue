<script setup lang="ts">
import { useFormatNumber } from '@/composable/useFormatNumber';
import type { Boq } from '@/pages/projectControl/Progress/Types/progress.types';

defineProps<{
    boq: Boq;
}>();

const { formatDate } = useFormatNumber();
</script>

<template>
    <v-card>
        <div class="p-3">
            <div class="flex w-full flex-col gap-3">
                <div class="grid grid-cols-2">
                    <div>
                        <h1>{{ boq.project_name }}</h1>
                        <h3>{{ boq.project_number }}</h3>
                    </div>
                    <div class="flex items-center justify-end">
                        <h3>{{ boq.client }}</h3>
                    </div>
                </div>
                <v-divider />
                <div class="grid grid-cols-2">
                    <div class="flex justify-between">
                        <div>
                            <span>Area :</span>
                            <h3>{{ boq.area }}</h3>
                        </div>
                        <v-divider vertical />
                        <div>
                            <span>Detailed Area :</span>
                            <h3>{{ boq.detailedArea }}</h3>
                        </div>
                        <v-divider vertical />
                        <div>
                            <span>Tanggal Mulai :</span>
                            <h3>{{ formatDate(boq.startDate) }}</h3>
                        </div>
                        <v-divider vertical />
                        <div>
                            <span>Tanggal Selesai :</span>
                            <h3>{{ formatDate(boq.endDate) }}</h3>
                        </div>
                        <v-divider vertical />
                    </div>
                    <div class="flex justify-end">
                        <v-btn
                            text="Actions"
                            variant="outlined"
                            color="primary"
                            prepend-icon="mdi-lightning-bolt"
                            append-icon="mdi-chevron-down"
                        />
                    </div>
                </div>
            </div>
        </div>
    </v-card>
</template>

<style scoped></style>
