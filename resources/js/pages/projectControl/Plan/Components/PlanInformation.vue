<script setup lang="ts">
import { ref } from 'vue';
import { useFormatNumber } from '@/composable/useFormatNumber';
import type { Boq } from '@/pages/projectControl/Plan/Types/plan.type';

defineProps<{
    boq: Boq;
}>();

defineEmits<{
    (e: 'update-menu', id: number): void;
}>();

const { formatDate } = useFormatNumber();
const isMenuOpen = ref(false);
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
                            <h3>{{ boq.detailed_area }}</h3>
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
                        <v-menu v-model="isMenuOpen" location="bottom end">
                            <template v-slot:activator="{ props: menuProps }">
                                <v-btn
                                    prepend-icon="mdi-lightning-bolt"
                                    :append-icon="
                                        isMenuOpen
                                            ? 'mdi-chevron-up'
                                            : 'mdi-chevron-down'
                                    "
                                    variant="outlined"
                                    color="primary"
                                    text="Acrions"
                                    v-bind="menuProps"
                                />
                            </template>
                            <v-list>
                                <v-list-item
                                    base-color="success"
                                    prepend-icon="mdi-update"
                                    title="Update"
                                    @click="() => {}"
                                />
                            </v-list>
                        </v-menu>
                    </div>
                </div>
            </div>
        </div>
    </v-card>
</template>

<style scoped></style>
