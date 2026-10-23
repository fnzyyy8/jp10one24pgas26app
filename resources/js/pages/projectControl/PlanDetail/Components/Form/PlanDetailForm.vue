<script setup lang="ts">
import AppDatePicker from '@/components/AppDatePicker.vue';
import type { Boq } from '@/pages/projectControl/PlanDetail/Types/plan.detail';

defineProps<{
    boq: Boq;
    loading: boolean;
}>();

const emits = defineEmits<{
    (e: 'submit-create'): void;
}>();

const volume = defineModel<number>('volume', { required: true });
const date = defineModel<Date | null>('date', { required: true });

const dialog = defineModel({ default: false });
</script>

<template>
    <v-dialog v-model="dialog" max-width="500">
        <v-card>
            <div class="flex flex-col gap-3 p-3">
                <div>
                    <h1>Create Plan Detail</h1>
                </div>
                <div class="flex gap-3">
                    <AppDatePicker
                        :min="boq.startDate"
                        :max="boq.endDate"
                        v-model="date"
                    />
                    <v-number-input label="Volume" v-model="volume" />
                </div>
                <div class="flex justify-end gap-3">
                    <v-btn
                        @click="emits('submit-create')"
                        color="success"
                        text="Submit"
                        :disabled="loading"
                    />
                    <v-btn
                        color="error"
                        text="Batal"
                        @click="dialog = false"
                        :loading="loading"
                    />
                </div>
            </div>
        </v-card>
    </v-dialog>
</template>

<style scoped></style>
