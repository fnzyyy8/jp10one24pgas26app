<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import MiniProgressChart from '@/components/chart/MiniProgressChart.vue';
import { useFormatNumber } from '@/composable/useFormatNumber';
import PlanMenu from '@/pages/projectControl/Plan/Components/Table/PlanMenu.vue';
import {
    GROUP_TABLE,
    mapPlanToTableItems,
} from '@/pages/projectControl/Plan/Mappers/planTable.mapper';
import type { Plan } from '@/pages/projectControl/Plan/Types/plan.type';

const props = defineProps<{
    plans: Plan[];
}>();

const headers = [
    { title: 'Nama Pekerjaan', key: 'name', width: '500px' },
    { title: 'Harga', key: 'price', align: 'start' as const },
    { title: 'Volume', key: 'volume', align: 'start' as const },
    { title: 'plan (%)', key: 'percentage', align: 'center' as const },
    { title: 'Total', key: 'total', align: 'start' as const },
    { title: 'Aksi', key: 'actions', sortable: false },
];

const groupBy = [
    { key: '_groupSection', order: false as const },
    { key: '_groupCategory', order: false as const },
    { key: '_groupSubCategory', order: false as const },
];

function isPlaceholderGroup(value: unknown): boolean {
    return (
        value === GROUP_TABLE.noCategory || value === GROUP_TABLE.noSubCategory
    );
}

const opened = ref<string[]>([]);
const initializedOpenedGroup = ref(false);

function createGroupId(parentKey: string, key: string, value: string): string {
    return `${parentKey}_${key}_${value}`;
}

const items = computed(() => mapPlanToTableItems(props.plans));
function getAllGroupIds(): string[] {
    const groupIds = new Set<string>();

    for (const item of items.value) {
        const sectionId = createGroupId(
            'root',
            '_groupSection',
            item._groupSection,
        );

        const categoryId = createGroupId(
            sectionId,
            '_groupCategory',
            item._groupCategory,
        );

        const subCategoryId = createGroupId(
            categoryId,
            '_groupSubCategory',
            item._groupSubCategory,
        );

        groupIds.add(sectionId);
        groupIds.add(categoryId);
        groupIds.add(subCategoryId);
    }

    return [...groupIds];
}

watch(
    items,
    (currentItems) => {
        if (initializedOpenedGroup.value || currentItems.length === 0) {
            return;
        }

        opened.value = getAllGroupIds();
        initializedOpenedGroup.value = true;
    },
    {
        immediate: true,
    },
);
const emit = defineEmits<{
    (e: 'open-volume', plan: Plan): void;
    (e: 'open-plan-detail', plan: Plan): void;
}>();

const { formatRupiah, formatQty } = useFormatNumber();
</script>

<template>
    <v-card>
        <div class="p-3">
            <v-data-table
                fixed-header
                v-model:opened="opened"
                height="650"
                :headers="headers"
                :items="items"
                :group-by="groupBy"
                item-value="id"
                :items-per-page="-1"
                hide-default-footer
                class="plan-table"
            >
                <template
                    #group-header="{ item, columns, toggleGroup, isGroupOpen }"
                >
                    <tr
                        v-if="!isPlaceholderGroup(item.value)"
                        :class="['group-row', `group-level-${item.depth}`]"
                        @click="toggleGroup(item)"
                        @keydown.enter.prevent="toggleGroup(item)"
                        @keydown.space.prevent="toggleGroup(item)"
                    >
                        <td :colspan="columns.length">
                            <div
                                class="ga-2 flex items-center"
                                :style="{
                                    paddingInlineStart: `${item.depth * 16}px`,
                                }"
                            >
                                <v-btn
                                    :icon="
                                        isGroupOpen(item)
                                            ? 'mdi-chevron-down'
                                            : 'mdi-chevron-right'
                                    "
                                    size="small"
                                    variant="text"
                                    density="comfortable"
                                />
                                <strong>{{ item.value }}</strong>
                            </div>
                        </td>
                    </tr>
                </template>

                <template #[`item.price`]="{ value }">
                    {{ formatRupiah(Number(value)) }}
                </template>

                <template #[`item.volume`]="{ value }">
                    {{ formatQty(Number(value)) }}
                </template>

                <template #[`item.percentage`]="{ value }">
                    <MiniProgressChart :value="Number(value)" />
                </template>

                <template #[`item.total`]="{ value }">
                    {{ formatRupiah(Number(value)) }}
                </template>
                <template #[`item.actions`]="{ item }">
                    <PlanMenu
                        :plan="item"
                        @open-volume="emit('open-volume', item)"
                        @open-plan-detail="emit('open-plan-detail', item)"
                    />
                </template>

                <template #no-data>
                    <div class="text-medium-emphasis pt-8 text-center">
                        Tidak ada data
                    </div>
                </template>
            </v-data-table>
        </div>
    </v-card>
</template>

<style scoped>
.plan-table :deep(table) {
    width: 100%;
    min-width: 800px;
}

.plan-table :deep(th) {
    white-space: nowrap;
    font-weight: 600;
}

.group-row {
    cursor: pointer;
    user-select: none;
    transition: background-color 0.15s ease;
}

.group-row:hover {
    filter: brightness(0.97);
}

.group-row:focus-visible {
    outline: 2px solid #1976d2;
    outline-offset: -2px;
}

.group-level-0 {
    background-color: #eaf1fc;
}

.group-level-1 {
    background-color: #f1f5f9;
}

.group-level-2 {
    background-color: #f8fafc;
}

.plan-table :deep(tbody tr:hover) {
    background-color: rgba(25, 118, 210, 0.04);
}
</style>
