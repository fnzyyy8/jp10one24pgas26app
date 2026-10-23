<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

import WorkerCertificateCreateDialog from '@/pages/manPower/Worker/components/Dialog/WorkerCertificateCreateDialog.vue';
import WorkerCertificateDialog from '@/pages/manPower/Worker/components/Dialog/WorkerCertificateDialog.vue';
import type { WorkerCertificate } from '@/pages/manPower/Worker/types/workerCertificate';
import { route } from 'ziggy-js';

const props = defineProps<{
    workerId: number;
    initialCertificates: WorkerCertificate[];
}>();

const search = ref('');
const page = ref(1);
const itemsPerPage = ref(5);

const showCreateDialog = ref(false);
const showDetailDialog = ref(false);
const showDeleteDialog = ref(false);
const deleting = ref(false);

const selectedCertificate = ref<WorkerCertificate | null>(null);

const certificates = computed(() => props.initialCertificates);

const filteredCertificates = computed(() => {
    const keyword = search.value.trim().toLowerCase();

    if (!keyword) {
        return certificates.value;
    }

    return certificates.value.filter((certificate) =>
        certificate.certificate_name.toLowerCase().includes(keyword),
    );
});

const totalPages = computed(() =>
    Math.max(
        1,
        Math.ceil(filteredCertificates.value.length / itemsPerPage.value),
    ),
);

const paginatedCertificates = computed(() => {
    const start = (page.value - 1) * itemsPerPage.value;

    return filteredCertificates.value.slice(start, start + itemsPerPage.value);
});

watch(search, () => {
    page.value = 1;
});

watch(itemsPerPage, () => {
    page.value = 1;
});

watch(totalPages, (total) => {
    if (page.value > total) {
        page.value = total;
    }
});

function getRowNumber(certificateId: number): number {
    const index = paginatedCertificates.value.findIndex(
        (certificate) => certificate.id === certificateId,
    );

    if (index === -1) {
        return 0;
    }

    return index + 1 + (page.value - 1) * itemsPerPage.value;
}

function getDocumentColor(type: string | null): string {
    switch (type?.toUpperCase()) {
        case 'PDF':
            return 'red';

        case 'PNG':
            return 'green';

        case 'JPG':
        case 'JPEG':
            return 'blue';

        case 'WEBP':
            return 'purple';

        default:
            return 'grey';
    }
}

function formatDate(value: string | null): string {
    if (!value) {
        return '-';
    }

    const date = new Date(`${value}T00:00:00`);

    if (Number.isNaN(date.getTime())) {
        return value;
    }

    return new Intl.DateTimeFormat('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    }).format(date);
}

function openDetail(certificate: WorkerCertificate): void {
    selectedCertificate.value = certificate;
    showDetailDialog.value = true;
}

function confirmDelete(certificate: WorkerCertificate): void {
    selectedCertificate.value = certificate;
    showDetailDialog.value = false;
    showDeleteDialog.value = true;
}

function closeDeleteDialog(): void {
    if (!deleting.value) {
        showDeleteDialog.value = false;
    }
}

function deleteCertificate(): void {
    const certificate = selectedCertificate.value;

    if (!certificate || deleting.value) {
        return;
    }

    deleting.value = true;

    router.delete(
        route('worker.certificates.delete', {
            worker: props.workerId,
            certificateId: certificate.id,
        }),
        {
            preserveScroll: true,

            onSuccess: () => {
                showDeleteDialog.value = false;
                selectedCertificate.value = null;
            },

            onFinish: () => {
                deleting.value = false;
            },
        },
    );
}
</script>

<template>
    <v-card variant="outlined">
        <div class="d-flex align-center ga-3 pa-4 flex-wrap justify-end">
            <v-btn
                color="primary"
                prepend-icon="mdi-plus"
                @click="showCreateDialog = true"
            >
                Tambah Sertifikat
            </v-btn>
        </div>

        <v-divider />

        <v-data-table
            :headers="[
                { title: 'No.', key: 'number', sortable: false },
                { title: 'Nama Sertifikat', key: 'certificate_name' },
                { title: 'Kedaluwarsa', key: 'expired_date' },
                { title: 'Format', key: 'document_type' },
                { title: 'Aksi', key: 'actions', sortable: false },
            ]"
            :items="paginatedCertificates"
            :items-per-page="-1"
            hide-default-footer
            item-value="id"
            no-data-text="Belum ada sertifikat."
        >
            <template v-slot:[`item.number`]="{ item }">
                {{ getRowNumber(item.id) }}
            </template>

            <template v-slot:[`item.expired_date`]="{ item }">
                {{ formatDate(item.expired_date) }}
            </template>

            <template v-slot:[`item.document_type`]="{ item }">
                <v-chip
                    v-if="item.document_type"
                    size="small"
                    variant="tonal"
                    :color="getDocumentColor(item.document_type)"
                >
                    {{ item.document_type }}
                </v-chip>

                <span v-else>-</span>
            </template>

            <template v-slot:[`item.actions`]="{ item }">
                <v-tooltip text="Lihat sertifikat">
                    <template #activator="{ props: tooltipProps }">
                        <v-btn
                            v-bind="tooltipProps"
                            icon="mdi-eye-outline"
                            variant="text"
                            color="primary"
                            aria-label="Lihat sertifikat"
                            @click="openDetail(item)"
                        />
                    </template>
                </v-tooltip>
            </template>
        </v-data-table>

        <div
            v-if="filteredCertificates.length > 0"
            class="d-flex align-center justify-space-between pa-4 ga-3 flex-wrap"
        >
            <v-select
                v-model="itemsPerPage"
                label="Baris per halaman"
                :items="[5, 10, 25]"
                variant="outlined"
                density="compact"
                hide-details
                style="max-width: 170px"
            />

            <v-pagination
                v-model="page"
                :length="totalPages"
                :total-visible="5"
                density="comfortable"
            />
        </div>

        <WorkerCertificateCreateDialog
            v-model="showCreateDialog"
            :worker-id="props.workerId"
        />

        <WorkerCertificateDialog
            v-model="showDetailDialog"
            :certificate="selectedCertificate"
            @delete="confirmDelete"
        />

        <v-dialog
            v-model="showDeleteDialog"
            max-width="420"
            :persistent="deleting"
        >
            <v-card>
                <v-card-title> Hapus Sertifikat </v-card-title>

                <v-card-text>
                    Apakah Anda yakin ingin menghapus sertifikat
                    <strong>
                        {{ selectedCertificate?.certificate_name }}
                    </strong>
                    beserta dokumennya?
                </v-card-text>

                <v-card-actions class="pa-4">
                    <v-spacer />

                    <v-btn
                        variant="text"
                        :disabled="deleting"
                        @click="closeDeleteDialog"
                    >
                        Batal
                    </v-btn>

                    <v-btn
                        color="error"
                        :loading="deleting"
                        @click="deleteCertificate"
                    >
                        Hapus
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-card>
</template>
