<script setup lang="ts">
import { useFormatNumber } from '@/composable/useFormatNumber';
import PriceListDetailMenu from '@/pages/Engineering/PriceListDetail/components/table/PriceListDetailMenu.vue';
import type { Section } from '@/pages/Engineering/PriceListDetail/type/price-list-detail.type';

const tableHead = ['Nama Pekerjaan', 'Unit', 'Harga Satuan', 'Aksi'];

defineProps<{
    priceListId: number;
    items: Section[];
}>();

const { formatRupiah } = useFormatNumber();
</script>

<template>
    <v-card>
        <div class="p-3">
            <v-table height="650" fixedHeader>
                <thead>
                    <tr>
                        <th v-for="(item, index) in tableHead" :key="index">
                            {{ item }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <template
                        v-for="section in items"
                        :key="`sec-${section.id}`"
                    >
                        <tr class="bg-gray-300">
                            <td :colspan="tableHead.length">
                                <strong>{{ section.name }}</strong>
                            </td>
                        </tr>
                        <tr
                            v-for="item in section.itemDetails"
                            :key="`sec-item-${item.id}`"
                        >
                            <td>
                                {{ item.name }}
                            </td>
                            <td>
                                {{ item.unit }}
                            </td>
                            <td>
                                {{ formatRupiah(item.price) }}
                            </td>
                            <td>
                                <PriceListDetailMenu
                                    :id="item.id"
                                    :priceListId="priceListId"
                                />
                            </td>
                        </tr>
                        <template
                            v-for="category in section.categories"
                            :key="`cat-${category.id}`"
                        >
                            <tr class="bg-gray-200">
                                <td class="pl-6" :colspan="tableHead.length">
                                    <strong>{{ category.name }}</strong>
                                </td>
                            </tr>
                            <tr
                                v-for="item in category.itemDetails"
                                :key="`cat-item-${item.id}`"
                            >
                                <td>
                                    {{ item.name }}
                                </td>
                                <td>
                                    {{ item.unit }}
                                </td>
                                <td>
                                    {{ formatRupiah(item.price) }}
                                </td>
                                <td>
                                    <PriceListDetailMenu
                                        :id="item.id"
                                        :priceListId="priceListId"
                                    />
                                </td>
                            </tr>
                            <template
                                v-for="subCategory in category.subCategories"
                                :key="`subCat-${subCategory.id}`"
                            >
                                <tr class="bg-gray-100">
                                    <td
                                        class="pl-8"
                                        :colspan="tableHead.length"
                                    >
                                        <strong>{{ subCategory.name }}</strong>
                                    </td>
                                </tr>
                                <tr
                                    v-for="item in subCategory.itemDetails"
                                    :key="`subCat-item-${item.id}`"
                                >
                                    <td>{{ item.name }}</td>
                                    <td>{{ item.unit }}</td>
                                    <td>{{ formatRupiah(item.price) }}</td>
                                    <td>
                                        <PriceListDetailMenu
                                            :id="item.id"
                                            :priceListId="priceListId"
                                        />
                                    </td>
                                </tr>
                            </template>
                        </template>
                    </template>
                </tbody>
            </v-table>
        </div>
    </v-card>
</template>

<style scoped></style>
