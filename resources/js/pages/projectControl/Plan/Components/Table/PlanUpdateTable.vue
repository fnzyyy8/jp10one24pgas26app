<script setup lang="ts">
import { useFormatNumber } from '@/composable/useFormatNumber';
import type { Section } from '@/pages/projectControl/Plan/Types/plan.type';

defineProps<{
    sections: Section[];
    isIndeterminate: boolean;
}>();

const selectedIds = defineModel<number[]>('selectedIds', {
    required: true,
});
const isAllSelected = defineModel<boolean>('isAllSelected', {
    required: true,
});

const thead = ['Detail Pekerjaan', 'Harga', 'Satuan'];
const { formatRupiah } = useFormatNumber();
</script>

<template>
    <v-card>
        <div class="p-3">
            <v-table fixed-header height="660px" class="mt-3">
                <thead>
                    <tr>
                        <th>
                            <v-checkbox-btn
                                :indeterminate="
                                    isIndeterminate && !isAllSelected
                                "
                                v-model="isAllSelected"
                                color="primary"
                                density="compact"
                            />
                        </th>
                        <th v-for="(item, index) in thead" :key="index">
                            {{ item }}
                        </th>
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
                            v-for="unitPrice in section.unitPrices"
                            :key="`sec-item-${unitPrice.id}`"
                        >
                            <td>
                                <v-checkbox-btn
                                    v-model="selectedIds"
                                    :value="unitPrice.id"
                                    color="primary"
                                    density="compact"
                                />
                            </td>
                            <td>{{ unitPrice.name }}</td>
                            <td>{{ formatRupiah(unitPrice.price) }}</td>
                            <td>{{ unitPrice.unit }}</td>
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
                                v-for="unitPrice in category.unitPrices"
                                :key="`cat-item-${unitPrice.id}`"
                            >
                                <td>
                                    <v-checkbox-btn
                                        v-model="selectedIds"
                                        :value="unitPrice.id"
                                        color="primary"
                                        density="compact"
                                    />
                                </td>
                                <td>{{ unitPrice.name }}</td>
                                <td>{{ formatRupiah(unitPrice.price) }}</td>
                                <td>{{ unitPrice.unit }}</td>
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
                                    v-for="unitPrice in subCategory.unitPrices"
                                    :key="`subCat-item-${unitPrice.id}`"
                                >
                                    <td>
                                        <v-checkbox-btn
                                            v-model="selectedIds"
                                            :value="unitPrice.id"
                                            color="primary"
                                            density="compact"
                                        />
                                    </td>
                                    <td>{{ unitPrice.name }}</td>
                                    <td>{{ formatRupiah(unitPrice.price) }}</td>
                                    <td>{{ unitPrice.unit }}</td>
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
