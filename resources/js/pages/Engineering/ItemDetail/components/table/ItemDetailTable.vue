<script setup lang="ts">
import ItemDetailTableAction from '@/pages/Engineering/ItemDetail/components/table/ItemDetailTableAction.vue';
import type {
    Section,
    ItemDetail,
} from '@/pages/Engineering/ItemDetail/types/item-detail.type';

defineProps<{
    items: Section[];
}>();

const emit = defineEmits<{
    (e: 'update-item-detail', itemDetail: ItemDetail): void;
}>();
</script>

<template>
    <v-table fixed-header height="750" class="mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Detail Pekerjaan</th>
                <th>Satuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <template v-for="section in items" :key="`sec-${section.id}`">
                <tr class="bg-gray-300">
                    <td :colspan="4">
                        <strong>{{ section.name }}</strong>
                    </td>
                </tr>
                <tr
                    v-for="item in section.itemDetails"
                    :key="`sec-item-${item.id}`"
                >
                    <td>{{ item.sort_order }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.unit }}</td>
                    <td>
                        <ItemDetailTableAction
                            @update-item-detail="
                                emit('update-item-detail', item)
                            "
                            :itemDetailId="item.id"
                        />
                    </td>
                </tr>
                <template
                    v-for="category in section.categories"
                    :key="`cat-${category.id}`"
                >
                    <tr class="bg-gray-200">
                        <td :colspan="4" class="pl-8">
                            <strong>
                                {{ category.name }}
                            </strong>
                        </td>
                    </tr>
                    <tr
                        v-for="item in category.itemDetails"
                        :key="`cat-item-${item.id}`"
                    >
                        <td>{{ item.sort_order }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.unit }}</td>
                        <td>
                            <ItemDetailTableAction
                                @update-item-detail="
                                    emit('update-item-detail', item)
                                "
                                :itemDetailId="item.id"
                            />
                        </td>
                    </tr>
                    <template
                        v-for="subCategory in category.subCategories"
                        :key="`subCat-${subCategory.id}`"
                    >
                        <tr class="bg-gray-100">
                            <td :colspan="5" class="pl-12">
                                <strong>{{ subCategory.name }} :</strong>
                            </td>
                        </tr>
                        <tr
                            v-for="item in subCategory.itemDetails"
                            :key="`subCat-item-${item.id}`"
                        >
                            <td>{{ item.sort_order }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.unit }}</td>
                            <td>
                                <ItemDetailTableAction
                                    @update-item-detail="
                                        emit('update-item-detail', item)
                                    "
                                    :itemDetailId="item.id"
                                />
                            </td>
                        </tr>
                    </template>
                </template>
            </template>
        </tbody>
    </v-table>
</template>

<style scoped></style>
