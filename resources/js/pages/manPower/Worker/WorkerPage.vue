<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

import AppCard from '@/components/card/AppCard.vue';
import ConfirmationDialog from '@/components/ConfirmationDialog.vue';


import { useFormatNumber } from '@/composable/useFormatNumber';
import FormCreateWorker from '@/pages/manPower/Worker/components/FormCreateWorker.vue';
import { useWorkerActions } from '@/pages/manPower/Worker/composables/useWorkerActions';
import { useWorkerFollowUp } from '@/pages/manPower/Worker/composables/useWorkerFollowUp';

import type { Worker } from '@/pages/manPower/Worker/types';

import { useBreadcrumbStore } from '@/stores/useBreadcrumbStore';
import { route } from 'ziggy-js';

const breadcrumb = useBreadcrumbStore();
const { formatDate } = useFormatNumber();

const tableHead = [
    'Photo',
    'ID Card Number',
    'Name',
    'Based',
    'Phone Number',
    'Email',
    'Status',
    'Last Follow Up',
    'Aksi',
];

const props = defineProps<{
    workers: Worker[];
    workScopes: { id: number; name: string }[];
    basedOptions: string[];
    filters: {
        work_scope_id?: number | null;
        based?: string | null;
    };
}>();

const searchForm = ref({
    work_scope_id: props.filters?.work_scope_id ?? null,
    based: props.filters?.based ?? null,
});

const applyFilter = () => {
    router.get(route('worker.index'), searchForm.value, {
        preserveState: true,
        preserveScroll: true,
    });
};

const resetFilter = () => {
    searchForm.value = {
        work_scope_id: null,
        based: null,
    };

    applyFilter();
};

const {
    openCreateModal,
    confirmDeleteModal,
    openDeleteModal,
    isCreateOpen,
    isDeleteOpen,
    deleteLoading,
} = useWorkerActions();

const {
    isConfirmOpen,
    isLoading: followUpLoading,
    selectedWorkerId,
    selectedWorkerName,
    openConfirm,
    cancelConfirm,
    confirmFollowUp,
} = useWorkerFollowUp();

const getStatusConfig = (status: string | null | undefined) => {
    switch (status) {
        case 'active':
            return {
                label: 'Active',
                color: 'success',
            };

        case 'not active':
            return {
                label: 'Non Active',
                color: 'error',
            };

        case 'on work':
            return {
                label: 'On Work',
                color: 'warning',
            };

        default:
            return {
                label: status || '-',
                color: 'grey',
            };
    }
};

const formatFollowUpDate = (date: string | null | undefined): string => {
    return date ? formatDate(date) : '-';
};

onMounted(() => {
    breadcrumb.setBreadcrumbs([
        {
            title: 'WORKER',
            disabled: true,
        },
    ]);
});
</script>

<template>
    <AppCard
        btn-label="Create Worker"
        btn-icon="mdi-plus"
        @create="openCreateModal"
    />

    <v-card>
        <!-- Filter -->
        <div class="grid grid-cols-1 items-center gap-4 p-3 md:grid-cols-3">
            <v-autocomplete
                v-model="searchForm.work_scope_id"
                :items="workScopes"
                item-title="name"
                item-value="id"
                label="Filter by Work Scope"
                clearable
                density="comfortable"
                variant="outlined"
                hide-details
            />

            <v-select
                v-model="searchForm.based"
                :items="basedOptions"
                label="Filter by Based"
                clearable
                density="comfortable"
                variant="outlined"
                hide-details
            />

            <div class="flex justify-end gap-2">
                <v-btn
                    color="primary"
                    prepend-icon="mdi-filter"
                    text="Filter"
                    @click="applyFilter"
                />

                <v-btn
                    color="grey-darken-1"
                    variant="outlined"
                    prepend-icon="mdi-refresh"
                    text="Reset"
                    @click="resetFilter"
                />
            </div>
        </div>

        <!-- Create Worker -->
        <div class="flex w-full justify-end p-3">
            <FormCreateWorker
                v-model="isCreateOpen"
                :work-scopes="workScopes"
            />
        </div>

        <!-- Worker Table -->
        <v-table>
            <thead>
                <tr>
                    <th v-for="(item, index) in tableHead" :key="index">
                        {{ item }}
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="worker in props.workers" :key="worker.id">
                    <td>
                        <v-avatar size="45">
                            <v-img
                                v-if="worker.photo_url"
                                :src="worker.photo_url"
                                alt="Worker photo"
                            />

                            <v-icon v-else icon="mdi-account" />
                        </v-avatar>
                    </td>

                    <td>
                        {{ worker.id_card_number }}
                    </td>

                    <td>
                        {{ worker.name }}
                    </td>

                    <td>
                        {{ worker.based }}
                    </td>

                    <td>
                        {{ worker.phone_number }}
                    </td>

                    <td>
                        {{ worker.email }}
                    </td>

                    <!-- Worker Status -->
                    <td>
                        <v-chip
                            size="small"
                            variant="tonal"
                            :color="getStatusConfig(worker.work_status).color"
                        >
                            {{ getStatusConfig(worker.work_status).label }}
                        </v-chip>
                    </td>

                    <!-- Last Follow Up -->
                    <td>
                        {{ formatFollowUpDate(worker.last_follow_up) }}
                    </td>

                    <!-- Action Menu -->
                    <td>
                        <v-menu>
                            <template v-slot:activator="{ props: menuProps }">
                                <v-btn
                                    v-bind="menuProps"
                                    icon="mdi-dots-vertical"
                                    variant="text"
                                    size="small"
                                />
                            </template>

                            <v-list>
                                <v-list-item
                                    prepend-icon="mdi-calendar-check"
                                    title="Follow Up"
                                    base-color="success"
                                    :disabled="followUpLoading"
                                    @click="openConfirm(worker.id, worker.name)"
                                />

                                <v-list-item
                                    prepend-icon="mdi-pencil"
                                    title="Edit"
                                    base-color="warning"
                                    @click="
                                        router.visit(
                                            route('worker.edit', worker.id),
                                        )
                                    "
                                />

                                <v-list-item
                                    prepend-icon="mdi-delete"
                                    title="Delete"
                                    base-color="error"
                                    @click="openDeleteModal(worker.id)"
                                />
                            </v-list>
                        </v-menu>
                    </td>
                </tr>

                <!-- Empty State -->
                <tr v-if="!props.workers || props.workers.length === 0">
                    <td
                        :colspan="tableHead.length"
                        class="py-4 text-center text-gray-500"
                    >
                        Belum ada Worker
                    </td>
                </tr>
            </tbody>
        </v-table>

        <!-- Delete Confirmation -->
        <ConfirmationDialog
            v-model="isDeleteOpen"
            :loading="deleteLoading"
            @confirm="confirmDeleteModal"
        />

        <!-- Follow Up Confirmation -->
        <v-dialog
            v-model="isConfirmOpen"
            max-width="420"
            :persistent="followUpLoading"
        >
            <v-card>
                <v-card-title> Konfirmasi Follow Up </v-card-title>

                <v-card-text>
                    Apakah Follow up telah dilaksanakan ?

                    <div
                        v-if="selectedWorkerId !== null"
                        class="text-medium-emphasis mt-2"
                    >
                        Atas Pekerja {{ selectedWorkerName }}
                    </div>
                </v-card-text>

                <v-card-actions>
                    <v-spacer />

                    <v-btn
                        variant="text"
                        :disabled="followUpLoading"
                        @click="cancelConfirm"
                    >
                        Batal
                    </v-btn>

                    <v-btn
                        color="success"
                        variant="flat"
                        :loading="followUpLoading"
                        @click="confirmFollowUp"
                    >
                        Konfirmasi
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-card>
</template>

<style scoped></style>
