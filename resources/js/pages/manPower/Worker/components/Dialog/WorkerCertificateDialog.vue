<script setup lang="ts">
import { computed, ref } from 'vue';
import type { WorkerCertificate } from '@/pages/manPower/Worker/types/workerCertificate';

const props = defineProps<{
    modelValue: boolean;
    certificate: WorkerCertificate | null;
}>();

const emit = defineEmits<{
    'update:modelValue': [value: boolean];
    delete: [certificate: WorkerCertificate];
    edit: [payload: { certificate: WorkerCertificate; document: File }];
}>();

const dialog = computed({
    get: () => props.modelValue,
    set: (value: boolean) => emit('update:modelValue', value),
});

const fileInput = ref<HTMLInputElement | null>(null);
const selectedFile = ref<File | null>(null);

const isPdf = computed(() => props.certificate?.document_type === 'PDF');

const isImage = computed(() =>
    ['JPG', 'PNG', 'WEBP'].includes(props.certificate?.document_type ?? ''),
);

function openFilePicker(): void {
    fileInput.value?.click();
}

function handleFileChange(event: Event): void {
    const input = event.target as HTMLInputElement;
    const file = input.files?.[0];

    if (!file || !props.certificate) {
return;
}

    const allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'webp'];
    const extension = file.name.split('.').pop()?.toLowerCase();

    if (!extension || !allowedExtensions.includes(extension)) {
        window.alert('Format file harus PDF, JPG, JPEG, PNG, atau WEBP.');
        input.value = '';

        return;
    }

    if (file.size > 10 * 1024 * 1024) {
        window.alert('Ukuran dokumen maksimal 10 MB.');
        input.value = '';

        return;
    }

    selectedFile.value = file;

    emit('edit', {
        certificate: props.certificate,
        document: file,
    });

    input.value = '';
}

function requestDelete(): void {
    if (props.certificate) {
        emit('delete', props.certificate);
    }
}
</script>

<template>
    <v-dialog v-model="dialog" max-width="800">
        <v-card>
            <v-card-title class="d-flex align-center justify-space-between">
                <span>Pratinjau Sertifikat</span>

                <v-btn
                    icon="mdi-close"
                    variant="text"
                    aria-label="Tutup dialog"
                    @click="dialog = false"
                />
            </v-card-title>

            <v-divider />

            <v-card-text v-if="certificate">
                <v-alert
                    v-if="!certificate.document_url"
                    type="warning"
                    variant="tonal"
                >
                    URL dokumen tidak tersedia.
                </v-alert>

                <v-img
                    v-else-if="isImage"
                    :src="certificate.document_url"
                    alt="Dokumen sertifikat"
                    max-height="500"
                    contain
                />

                <template v-else-if="isPdf">
                    <iframe
                        :src="certificate.document_url"
                        title="Pratinjau sertifikat PDF"
                        style="width: 100%; height: 500px; border: 0"
                    />

                    <v-btn
                        :href="certificate.document_url"
                        target="_blank"
                        rel="noopener noreferrer"
                        prepend-icon="mdi-open-in-new"
                        variant="text"
                        class="mt-2"
                    >
                        Buka PDF di tab baru
                    </v-btn>
                </template>

                <v-alert v-else type="info" variant="tonal">
                    Pratinjau dokumen tidak tersedia.

                    <div class="mt-2">
                        <a
                            v-if="certificate.document_url"
                            :href="certificate.document_url"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            Buka dokumen
                        </a>
                    </div>
                </v-alert>

                <div v-if="selectedFile" class="text-caption mt-2">
                    File dipilih: {{ selectedFile.name }}
                </div>

                <input
                    ref="fileInput"
                    type="file"
                    accept=".pdf,.jpg,.jpeg,.png,.webp"
                    hidden
                    @change="handleFileChange"
                />
            </v-card-text>

            <v-divider />

            <v-card-actions class="pa-4">
                <v-btn
                    color="error"
                    variant="outlined"
                    prepend-icon="mdi-delete"
                    @click="requestDelete"
                >
                    Hapus
                </v-btn>

                <v-btn
                    color="primary"
                    variant="outlined"
                    prepend-icon="mdi-file-edit-outline"
                    @click="openFilePicker"
                >
                    Edit Dokumen
                </v-btn>

                <v-spacer />
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
