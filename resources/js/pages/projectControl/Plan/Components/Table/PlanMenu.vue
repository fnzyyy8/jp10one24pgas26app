<script setup lang="ts">
import type { Plan } from '@/pages/projectControl/Plan/Types/plan.type';

const props = defineProps<{
    plan: Plan;
}>();
const emit = defineEmits<{
    (e: 'open-volume', plan: Plan): void;
    (e: 'open-plan-detail', plan: Plan): void;
}>();
</script>

<template>
    <v-menu location="bottom end">
        <template #activator="{ props }">
            <v-btn icon="mdi-dots-vertical" variant="text" v-bind="props" />
        </template>

        <v-list>
            <v-list-item
                prepend-icon="mdi-pencil-ruler"
                base-color="warning"
                title="Set Volume"
                @click="emit('open-volume', props.plan)"
            />
            <v-list-item
                prepend-icon="mdi-chart-timeline-variant"
                base-color="primary"
                title="Set Plan Date"
                @click="emit('open-plan-detail',props.plan)"
            />
        </v-list>
    </v-menu>
</template>

<style scoped></style>
