<script setup lang="ts">
import { useFormatNumber } from '@/composable/useFormatNumber';
import type {
    ItemDetail,
    PlanDetail,
} from '@/pages/projectControl/PlanDetail/Types/plan.detail';

const tableHead = ['Date', 'Volume', '(%)', 'Aksi'];

defineProps<{
    itemDetail: ItemDetail;
    planDetails: PlanDetail[];
}>();

const { formatDate } = useFormatNumber();

const emit = defineEmits<{
    (e: 'open-create'): void;
    (e: 'delete', planDetailId: number): void;
}>();
</script>

<template>
    <v-card>
        <div class="p-3">
            <div class="my-2 grid grid-cols-1">
                <div class="flex justify-end">
                    <v-btn
                        variant="elevated"
                        prepend-icon="mdi-plus"
                        text="Tambah Rencana"
                        color="primary"
                        @click="emit('open-create')"
                    />
                </div>
            </div>
            <v-table height="280">
                <thead>
                    <tr>
                        <th v-for="(item, index) in tableHead" :key="index">
                            {{ item }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="!planDetails" class="text-center text-gray-500">
                        <td :colspan="tableHead.length">Tidak Ada Data</td>
                    </tr>
                    <tr
                        v-else
                        v-for="planDetail in planDetails"
                        :key="planDetail.id"
                    >
                        <td>{{ formatDate(planDetail.date) }}</td>
                        <td>
                            {{ Number(planDetail.volume) }}
                            {{ planDetail.unit }}
                        </td>
                        <td>
                            {{
                                (
                                    (planDetail.volume / itemDetail.volume) *
                                    100
                                ).toFixed(2)
                            }}
                            %
                        </td>
                        <td>
                            <v-menu>
                                <template v-slot:activator="{ props }">
                                    <v-btn
                                        variant="text"
                                        icon="mdi-dots-vertical"
                                        v-bind="props"
                                    />
                                </template>
                                <v-list>
                                    <v-list-item
                                        prepend-icon="mdi-delete"
                                        title="Hapus"
                                        base-color="error"
                                        @click="emit('delete', planDetail.id)"
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
