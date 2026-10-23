<script setup lang="ts">
import { onMounted, ref } from 'vue';

import AppCard from '@/components/card/AppCard.vue';
import ConfirmationDialog from '@/components/ConfirmationDialog.vue';

import { useFormatNumber } from '@/composable/useFormatNumber';
import FormCreateProject from '@/pages/projects/components/FormCreateProject.vue';
import FormUpdateProject from '@/pages/projects/components/FormUpdateProject.vue';
import { useProjectActions } from '@/pages/projects/composables/useProjectActions';
import type { PriceListOption, Project } from '@/pages/projects/types';
import { useBreadcrumbStore } from '@/stores/useBreadcrumbStore';

const breadcrumb = useBreadcrumbStore();

const { formatRupiah } = useFormatNumber();

const tableHead = [
    'Status',
    'Project Name',
    'Anggaran',
    'Area',
    'Client',
    'Mulai',
    'Selesai',
    'Aksi',
];

defineProps<{
    projects: Project[];
    priceListOptions: PriceListOption[];
}>();

const openEditModalRef = ref<InstanceType<typeof FormUpdateProject> | null>(
    null,
);

const {
    openCreateModal,
    confirmDeleteModal,
    openDeleteModal,
    isCreateOpen,
    isDeleteOpen,
    deleteLoading,
} = useProjectActions();

onMounted(() => {
    breadcrumb.setBreadcrumbs([
        {
            title: 'PROJECT',
            disabled: true,
        },
    ]);
});

const { formatDate } = useFormatNumber();
</script>

<template>
    <AppCard
        btn-label="Create project"
        btn-icon="mdi-plus"
        @create="openCreateModal"
    />
    <v-card>
        <div class="flex w-full justify-end p-3">
            <FormCreateProject
                v-model="isCreateOpen"
                :priceListOptions="priceListOptions"
            />
            <FormUpdateProject
                ref="openEditModalRef"
                :priceListOptions="priceListOptions"
            />
        </div>
        <v-table>
            <thead>
                <tr>
                    <th v-for="(item, index) in tableHead" :key="index">
                        {{ item }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="project in projects" :key="project.id">
                    <td>
                        <small
                            v-if="project.status === 'on progress'"
                            class="bg-warning rounded-full p-2"
                        >
                            {{ project.status }}
                        </small>
                        <small
                            v-if="project.status === 'finished'"
                            class="bg-success rounded-full p-2"
                        >
                            {{ project.status }}
                        </small>
                        <small
                            v-if="project.status === 'cancel'"
                            class="bg-error rounded-full p-2"
                        >
                            {{ project.status }}
                        </small>
                    </td>
                    <td>
                        {{ project.project_name }}
                    </td>
                    <td>
                        {{ formatRupiah(project.budget) }}
                    </td>
                    <td>
                        {{ project.area }}
                    </td>
                    <td>
                        {{ project.client }}
                    </td>
                    <td>
                        {{ formatDate(project.start_date) }}
                    </td>
                    <td>
                        {{ formatDate(project.end_date) }}
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
                                            project.id,
                                            project,
                                        )
                                    "
                                />
                                <v-list-item
                                    prepend-icon="mdi-delete"
                                    title="Delete"
                                    base-color="error"
                                    @click="openDeleteModal(project.id)"
                                />
                            </v-list>
                        </v-menu>
                    </td>
                </tr>
                <tr v-if="!projects || projects.length === 0">
                    <td
                        :colspan="tableHead.length"
                        class="py-4 text-center text-gray-500"
                    >
                        Belum ada Project
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
</template>

<style scoped></style>
