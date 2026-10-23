<script setup lang="ts">
import type { PriceList } from '@/pages/Engineering/PriceList/type/price-list.type';

defineProps<{
    priceLists: PriceList[];
}>();

const emit = defineEmits<{
    (e: 'show-price-list', id: number): void;
    (e: 'update-price-list', priceList: PriceList): void;
    (e: 'delete-price-list', id: number): void;
}>();
</script>

<template>
    <v-table>
        <thead>
            <tr>
                <th>Nama Harsat</th>
                <th>Nomor Harsat</th>
                <th>Client</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="priceList in priceLists" :key="priceList.id">
                <td>{{ priceList.name }}</td>
                <td>{{ priceList.number }}</td>
                <td>{{ priceList.client }}</td>
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
                                title="View"
                                base-color="grey"
                                prepend-icon="mdi-eye"
                                @click="emit('show-price-list', priceList.id)"
                            />

                            <v-list-item
                                title="Update"
                                base-color="warning"
                                prepend-icon="mdi-pencil"
                                @click="emit('update-price-list', priceList)"
                            />
                            <v-list-item
                                title="Delete"
                                base-color="error"
                                prepend-icon="mdi-delete"
                                @click="emit('delete-price-list', priceList.id)"
                            />
                        </v-list>
                    </v-menu>
                </td>
            </tr>
        </tbody>
    </v-table>
</template>

<style scoped></style>
