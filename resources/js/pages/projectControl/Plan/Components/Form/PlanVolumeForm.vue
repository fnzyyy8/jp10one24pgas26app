<script setup lang="ts">
import type { Plan } from '@/pages/projectControl/Plan/Types/plan.type';

const dialog = defineModel<boolean>({ default: false });

const volume = defineModel<number | null>('volume', {
    default: null,
    required: true,
});

defineProps<{
    plan: Plan | null;
}>();

const emit = defineEmits<{
    (e: 'submit-volume'): void;
}>();
</script>

<template>
    <v-dialog v-model="dialog" width="700">
        <v-card>
            <div class="p-3">
                <h1>Volume</h1>
            </div>
            <v-divider />
            <div class="grid grid-cols-2 gap-3 p-3">
                <div class="col-span-2">
                    <div
                        class="flex gap-2 rounded-lg border border-gray-300 p-3"
                    >
                        <h3>Section :</h3>
                        <span>{{ plan?.section ?? '-' }}</span>
                    </div>
                </div>
                <div>
                    <div class="gap-2 rounded-lg border border-gray-300 p-3">
                        <h3 class="mb-2">Category :</h3>
                        <span>{{ plan?.category ?? '-' }}</span>
                    </div>
                </div>
                <div>
                    <div class="gap-2 rounded-lg border border-gray-300 p-3">
                        <h3 class="mb-2">Sub Category :</h3>
                        <span>{{ plan?.subCategory ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="min-h-40 rounded-lg border border-gray-300 p-3">
                        <h3 class="mb-2">Judul Pekerjaan :</h3>
                        <span>{{ plan?.name ?? '-' }}</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-3 p-3">
                <div class="col-span-2">
                    <v-number-input
                        v-model="volume"
                        grouping="always"
                        hide-details
                    />
                </div>
                <div class="rounded-lg bg-gray-200 p-3">
                    <span> {{ plan?.unit ?? '-' }} </span>
                </div>
            </div>
            <div class="flex justify-end gap-3 p-3">
                <v-btn
                    text="Submit"
                    color="success"
                    @click="emit('submit-volume')"
                />
                <v-btn text="Batal" color="error" @click="dialog = false" />
            </div>
        </v-card>
    </v-dialog>
</template>

<style scoped></style>
