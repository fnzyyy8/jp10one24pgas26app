<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';

import AppCard from '@/components/card/AppCard.vue';
import DoughnutChart from '@/components/chart/DoughnutChart.vue';
import ConfirmationDialog from '@/components/ConfirmationDialog.vue';

import FormCreateWorkScope from '@/pages/manPower/WorkScope/components/FormCreateWorkScope.vue';
import FormUpdateWorkScope from '@/pages/manPower/WorkScope/components/FormUpdateWorkScope.vue';

import { useWorkScopeActions } from '@/pages/manPower/WorkScope/composables/useWorkScopeActions';
import type {
    WorkScope,
    WorkerSummary,
} from '@/pages/manPower/WorkScope/types';

import { useBreadcrumbStore } from '@/stores/useBreadcrumbStore';

const breadcrumb = useBreadcrumbStore();

const tableHead = ['Name', 'Aksi'];

const props = defineProps<{
    workScopes: WorkScope[];
    workerSummary: WorkerSummary;
}>();

const openEditModalRef = ref<InstanceType<typeof FormUpdateWorkScope> | null>(
    null,
);

const {
    openCreateModal,
    confirmDeleteModal,
    openDeleteModal,
    isCreateOpen,
    isDeleteOpen,
    deleteLoading,
} = useWorkScopeActions();

/**
 * Data Doughnut Chart berdasarkan jumlah worker
 * dari seluruh WorkScope yang ditampilkan.
 */
const workerStatusChartData = computed(() => [
    {
        name: 'Active Workers',
        value: props.workerSummary.active_workers ?? 0,
        color: '#16A34A',
    },
    {
        name: 'Non Active Workers',
        value: props.workerSummary.non_active_workers ?? 0,
        color: '#DC2626',
    },
    {
        name: 'On Work Workers',
        value: props.workerSummary.on_work_workers ?? 0,
        color: '#F59E0B',
    },
]);

onMounted(() => {
    breadcrumb.setBreadcrumbs([
        {
            title: 'WORK SCOPE',
            disabled: true,
        },
    ]);
});
</script>

<template>
    <AppCard
        btn-label="Create Work Scope"
        btn-icon="mdi-plus"
        @create="openCreateModal"
    />
    <div class="grid grid-cols-3 gap-3">
        <v-card>
            <DoughnutChart
                title="Worker Status"
                :data="workerStatusChartData"
                height="350px"
            />
        </v-card>

        <v-card class="col-span-2">
            <div class="flex w-full justify-end p-3">
                <FormCreateWorkScope v-model="isCreateOpen" />
                <FormUpdateWorkScope ref="openEditModalRef" />
            </div>

            <!-- WorkScope Table -->
            <v-table>
                <thead>
                    <tr>
                        <th v-for="(item, index) in tableHead" :key="index">
                            {{ item }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="workScope in props.workScopes"
                        :key="workScope.id"
                    >
                        <td>
                            {{ workScope.name }}
                        </td>

                        <td>
                            <v-menu>
                                <template v-slot:activator="{ props }">
                                    <v-btn
                                        icon="mdi-dots-vertical"
                                        variant="text"
                                        size="small"
                                        v-bind="props"
                                    />
                                </template>

                                <v-list>
                                    <v-list-item
                                        prepend-icon="mdi-pencil"
                                        title="Edit"
                                        base-color="warning"
                                        @click="
                                            openEditModalRef?.openEditModal(
                                                workScope.id,
                                                workScope,
                                            )
                                        "
                                    />

                                    <v-list-item
                                        prepend-icon="mdi-delete"
                                        title="Delete"
                                        base-color="error"
                                        @click="openDeleteModal(workScope.id)"
                                    />
                                </v-list>
                            </v-menu>
                        </td>
                    </tr>

                    <tr
                        v-if="
                            !props.workScopes || props.workScopes.length === 0
                        "
                    >
                        <td
                            :colspan="tableHead.length"
                            class="py-4 text-center text-gray-500"
                        >
                            Belum ada Work Scope
                        </td>
                    </tr>
                </tbody>
            </v-table>

            <ConfirmationDialog
                v-model="isDeleteOpen"
                :loading="deleteLoading"
                @confirm="confirmDeleteModal"
            />
        </v-card>
    </div>
</template>

<style scoped></style>
