<script setup lang="ts">
import MiniProgressChart from '@/components/chart/MiniProgressChart.vue';
import { useFormatNumber } from '@/composable/useFormatNumber';
import PlanMenu from '@/pages/projectControl/Plan/Components/Table/PlanMenu.vue';
import type {
    Plan,
    PlanSection,
} from '@/pages/projectControl/Plan/Types/plan.type';

defineProps<{
    planSections: PlanSection[];
}>();

const emit = defineEmits<{
    (e: 'open-volume', plan: Plan): void;
    (e: 'open-plan-detail', plan: Plan): void;
}>();

const tableHead = ['Nama Pekerjaan', 'Harga', 'Volume', 'Plan (%)', 'Total'];

const { formatQty, formatRupiah } = useFormatNumber();
</script>

<template>
    <v-card>
        <div class="p-3">
            <v-table height="670" fixed-header class="plan-table">
                <thead>
                    <tr>
                        <th v-for="(item, index) in tableHead" :key="index">
                            {{ item }}
                        </th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <template
                        v-for="section in planSections"
                        :key="`sec-${section.id}`"
                    >
                        <tr class="bg-gray-300">
                            <td :colspan="tableHead.length + 1">
                                <strong>{{ section.name }}</strong>
                            </td>
                        </tr>
                        <tr
                            v-for="plan in section.plans"
                            :key="`sec-item-${plan.id}`"
                        >
                            <td>
                                {{ plan.name }}
                            </td>
                            <td>
                                {{ formatRupiah(plan.price) }}
                            </td>
                            <td>
                                {{ formatQty(plan.volume) }}
                            </td>
                            <td class="plan-cell">
                                <MiniProgressChart :value="plan.percentage" />
                            </td>
                            <td>
                                {{ formatRupiah((plan.volume ?? 0) * plan.price) }}
                            </td>
                            <td class="text-center">
                                <PlanMenu
                                    :plan="plan"
                                    @open-volume="emit('open-volume', plan)"
                                    @open-plan-detail="
                                        emit('open-plan-detail', plan)
                                    "
                                />
                            </td>
                        </tr>
                        <template
                            v-for="category in section.categories"
                            :key="`cat-${category.id}`"
                        >
                            <tr class="bg-gray-200">
                                <td
                                    class="pl-6"
                                    :colspan="tableHead.length + 1"
                                >
                                    <strong>{{ category.name }}</strong>
                                </td>
                            </tr>
                            <tr
                                v-for="plan in category.plans"
                                :key="`cat-item-${plan.id}`"
                            >
                                <td>
                                    {{ plan.name }}
                                </td>
                                <td>
                                    {{ formatRupiah(plan.price) }}
                                </td>
                                <td>
                                    {{ formatQty(plan.volume) }}
                                </td>
                                <td class="plan-cell text-center">
                                    <MiniProgressChart :value="plan.percentage" />
                                </td>
                                <td>
                                    {{
                                        formatRupiah(
                                            (plan.volume ?? 0) * plan.price,
                                        )
                                    }}
                                </td>
                                <td class="text-center">
                                    <PlanMenu
                                        :plan="plan"
                                        @open-volume="emit('open-volume', plan)"
                                        @open-plan-detail="
                                            emit('open-plan-detail', plan)
                                        "
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
                                        :colspan="tableHead.length + 1"
                                    >
                                        <strong>{{ subCategory.name }}</strong>
                                    </td>
                                </tr>
                                <tr
                                    v-for="plan in subCategory.plans"
                                    :key="`subCat-item-${plan.id}`"
                                >
                                    <td>{{ plan.name }}</td>
                                    <td>{{ formatRupiah(plan.price) }}</td>
                                    <td>
                                        {{ formatQty(plan.volume) }}
                                    </td>
                                    <td class="plan-cell">
                                        <MiniProgressChart :value="plan.percentage" />
                                    </td>
                                    <td>
                                        {{
                                            formatRupiah(
                                                (plan.volume ?? 0) * plan.price,
                                            )
                                        }}
                                    </td>
                                    <td class="text-center">
                                        <PlanMenu
                                            :plan="plan"
                                            @open-volume="
                                                emit('open-volume', plan)
                                            "
                                            @open-plan-detail="
                                                emit('open-plan-detail', plan)
                                            "
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

<style scoped>
:deep(.plan-table table) {
    width: 100%;
}

:deep(.plan-table th:nth-child(4)),
:deep(.plan-table td:nth-child(4)) {
    width: 1%;
    white-space: nowrap;
}
</style>
