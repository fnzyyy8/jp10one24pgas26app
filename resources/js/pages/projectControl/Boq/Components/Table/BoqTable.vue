<script setup lang="ts">
import { useFormatNumber } from '@/composable/useFormatNumber';
import type { Boq } from '@/pages/projectControl/Boq/Types/boq.type';

defineProps<{
    boqs: Boq[];
}>();

const emit = defineEmits<{
    (e: 'plan', id: number): void;
    (e: 'progress', id: number): void;
    (e: 'update-boq', boq: Boq): void;
    (e: 'delete-boq', id: number): void;
}>();

const tHead = [
    'Cust',
    'No. SPK',
    'Area',
    'Nama Pekerjaan',
    'Detail Area',
    'Anggaran',
    'Nilai Rencana',
    'Aksi',
];

const { formatRupiah } = useFormatNumber();
</script>

<template>
    <v-card>
        <div class="m-3">
            <div class="mt-3">
                <v-table>
                    <thead>
                        <tr>
                            <th v-for="(head, index) in tHead" :key="index">
                                {{ head }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="boq in boqs" :key="boq.id">
                            <td>
                                <VIcon
                                    v-if="boq.isMultipleCustomer"
                                    icon="mdi-account-group"
                                />

                                <VIcon v-else icon="mdi-account" />
                            </td>
                            <td>{{ boq.project_number }}</td>
                            <td>{{ boq.project_area }}</td>
                            <td>{{ boq.project_name }}</td>
                            <td>{{ boq.detailed_area }}</td>
                            <td>{{ formatRupiah(boq.project_budget) }}</td>
                            <td>{{ formatRupiah(boq.planBudget) }}</td>
                            <td>
                                <v-menu>
                                    <template v-slot:activator="{ props }">
                                        <v-btn
                                            icon="mdi-dots-vertical"
                                            variant="text"
                                            size="small"
                                            v-bind="props"
                                        ></v-btn>
                                    </template>
                                    <v-list>
                                        <v-list-item
                                            prepend-icon="mdi-trending-up"
                                            title="Progress"
                                            base-color="success"
                                            @click="emit('progress', boq.id)"
                                        />
                                        <v-list-item
                                            prepend-icon="mdi-clipboard-check"
                                            title="Plan"
                                            base-color="indigo"
                                            @click="emit('plan', boq.id)"
                                        />
                                        <v-list-item
                                            prepend-icon="mdi-pencil"
                                            title="Edit"
                                            base-color="warning"
                                            @click="emit('update-boq', boq)"
                                        />
                                        <v-list-item
                                            prepend-icon="mdi-delete"
                                            title="Delete"
                                            base-color="error"
                                            @click="emit('delete-boq', boq.id)"
                                        />
                                    </v-list>
                                </v-menu>
                            </td>
                        </tr>
                    </tbody>
                </v-table>
            </div>
        </div>
    </v-card>
</template>

<style scoped></style>
