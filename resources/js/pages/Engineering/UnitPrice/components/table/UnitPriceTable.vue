<script setup lang="ts">
import type {
    PriceList,
    Section,
    UnitPrice,
} from '@/pages/Engineering/UnitPrice/type/unit-price.type';

defineProps<{
    sections: Section[];
    priceList: PriceList;
    unitPrices: UnitPrice[];
    isIndeterminate: boolean;
}>();

const selectedIds = defineModel<number[]>('selectedIds', {
    required: true,
});
const isAllSelected = defineModel<boolean>('isAllSelected', {
    required: true,
});
</script>

<template>
    <v-card>
        <div
            class="flex items-center justify-between border-b bg-gray-50 px-4 py-2 font-mono text-xs"
        ></div>
        <div class="p-3">
            <v-table fixed-header height="650" class="mt-3">
                <thead>
                    <tr>
                        <th>
                            <v-checkbox-btn
                                v-model="isAllSelected"
                                :indeterminate="
                                    isIndeterminate && !isAllSelected
                                "
                                color="primary"
                                density="compact"
                            />
                        </th>
                        <th>No</th>
                        <th>Detail Pekerjaan</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <template
                        v-for="section in sections"
                        :key="`sec-${section.id}`"
                    >
                        <tr class="bg-gray-300">
                            <td :colspan="5">
                                <strong>{{ section.name }}</strong>
                            </td>
                        </tr>
                        <tr
                            v-for="item in section.itemDetails"
                            :key="`sec-item-${item.id}`"
                        >
                            <td>
                                <v-checkbox-btn
                                    v-model="selectedIds"
                                    :value="Number(item.id)"
                                    color="primary"
                                    density="compact"
                                />
                            </td>
                            <td>{{ item.sort_order }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.unit }}</td>
                        </tr>
                        <template
                            v-for="category in section.categories"
                            :key="`cat-${category.id}`"
                        >
                            <tr class="bg-gray-200">
                                <td :colspan="5" class="pl-8">
                                    <strong>
                                        {{ category.name }}
                                    </strong>
                                </td>
                            </tr>
                            <tr
                                v-for="item in category.itemDetails"
                                :key="`cat-item-${item.id}`"
                            >
                                <td>
                                    <v-checkbox-btn
                                        v-model="selectedIds"
                                        :value="Number(item.id)"
                                        color="primary"
                                        density="compact"
                                    />
                                </td>
                                <td>{{ item.sort_order }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.unit }}</td>
                            </tr>
                            <template
                                v-for="subCategory in category.subCategories"
                                :key="`subCat-${subCategory.id}`"
                            >
                                <tr class="bg-gray-100">
                                    <td :colspan="5" class="pl-12">
                                        <strong
                                            >{{ subCategory.name }} :</strong
                                        >
                                    </td>
                                </tr>
                                <tr
                                    v-for="item in subCategory.itemDetails"
                                    :key="`subCat-item-${item.id}`"
                                >
                                    <td>
                                        <v-checkbox-btn
                                            v-model="selectedIds"
                                            :value="Number(item.id)"
                                            color="primary"
                                            density="compact"
                                        />
                                    </td>
                                    <td>{{ item.sort_order }}</td>
                                    <td>{{ item.name }}</td>
                                    <td>{{ item.unit }}</td>
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
