<script setup lang="ts">
import { useFormatNumber } from '@/composable/useFormatNumber';
import type { RecordPrice } from '@/pages/Engineering/RecordPrice/types/record-price.type';

const tableHead = [
    'Tanggal',
    'Harga',
    'Deskripsi Perubahan',
    'create_at',
    'aksi',
];

const emit = defineEmits<{
    (e: 'open-create-dialog'): void;
    (e: 'delete-record-price', id: number): void;
}>();
defineProps<{
    recordPrices: RecordPrice[];
}>();

const { formatRupiah, formatDate } = useFormatNumber();
</script>

<template>
    <v-card>
        <div class="p-3">
            <div class="flex justify-end">
                <v-btn
                    text="Create Price"
                    color="primary"
                    prepend-icon="mdi-plus"
                    @click="emit('open-create-dialog')"
                />
            </div>
            <v-table>
                <thead>
                    <tr>
                        <th v-for="(item, index) in tableHead" :key="index">
                            {{ item }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="!recordPrices || recordPrices.length === 0">
                        <td
                            class="text-center text-gray-400"
                            :colspan="tableHead.length"
                        >
                            Tidak ada data
                        </td>
                    </tr>
                    <tr
                        v-else
                        v-for="recordPrice in recordPrices"
                        :key="recordPrice.id"
                    >
                        <td>
                            {{ formatDate(recordPrice.date) }}
                        </td>
                        <td>
                            {{ formatRupiah(recordPrice.price) }}
                        </td>
                        <td>
                            {{ recordPrice.notes }}
                        </td>
                        <td>
                            {{ formatDate(recordPrice.created_at) }}
                        </td>
                        <td>
                            <v-menu>
                                <template v-slot:activator="{ props }">
                                    <v-btn
                                        icon="mdi-dots-vertical"
                                        variant="text"
                                        v-bind="props"
                                    />
                                </template>
                                <v-list>
                                    <v-list-item
                                        prepend-icon="mdi-delete"
                                        base-color="error"
                                        title="Delete"
                                        @click="
                                            emit(
                                                'delete-record-price',
                                                recordPrice.id,
                                            )
                                        "
                                    />
                                </v-list>
                            </v-menu>
                        </td>
                    </tr>
                </tbody>
            </v-table>
        </div>
    </v-card>
</template>

<style scoped></style>
