<script setup lang="ts">
import { computed, watch } from 'vue';
import { useWorkerCertificate } from '@/pages/manPower/Worker/composables/useWorkerCertificate';

const props = defineProps<{
    modelValue: boolean;
    workerId: number;
}>();

const emit = defineEmits<{
    'update:modelValue': [value: boolean];
    created: [];
}>();

const dialog = computed({
    get: () => props.modelValue,
    set: (value: boolean) => emit('update:modelValue', value),
});

const { form, errors, loading, resetForm, setDocument, create } =
    useWorkerCertificate(props.workerId);

watch(
    () => props.modelValue,
    (isOpen) => {
        if (isOpen) {
            resetForm();
        }
    },
);

function closeDialog(): void {
    if (!loading.value) {
        dialog.value = false;
    }
}

function handleDocumentChange(files: File | File[] | null): void {
    const file = Array.isArray(files) ? (files[0] ?? null) : (files ?? null);

    setDocument(file);
}

function submit(): void {
    create(() => {
        dialog.value = false;
        emit('created');
    });
}
</script>

<template>
    <v-dialog
        v-model="dialog"
        max-width="600"
        :persistent="loading"
        @keydown.esc="closeDialog"
    >
        <v-card>
            <v-card-title class="d-flex align-center justify-space-between">
                <span>Tambah Sertifikat</span>

                <v-btn
                    icon="mdi-close"
                    variant="text"
                    aria-label="Tutup dialog"
                    :disabled="loading"
                    @click="closeDialog"
                />
            </v-card-title>

            <v-divider />

            <v-card-text>
                <v-text-field
                    v-model="form.certificate_name"
                    label="Nama Sertifikat"
                    variant="outlined"
                    density="comfortable"
                    maxlength="255"
                    counter="255"
                    :error-messages="errors.certificate_name"
                    :disabled="loading"
                    required
                />

                <v-text-field
                    v-model="form.expired_date"
                    label="Tanggal Kedaluwarsa"
                    type="date"
                    variant="outlined"
                    density="comfortable"
                    :error-messages="errors.expired_date"
                    :disabled="loading"
                    clearable
                />

                <v-file-input
                    label="Dokumen Sertifikat"
                    variant="outlined"
                    density="comfortable"
                    accept=".pdf,.jpg,.jpeg,.png,.webp"
                    prepend-icon="mdi-paperclip"
                    show-size
                    :error-messages="errors.document"
                    :disabled="loading"
                    required
                    @update:model-value="handleDocumentChange"
                />

                <div class="text-caption text-medium-emphasis">
                    Format PDF, JPG, JPEG, PNG, atau WEBP. Maksimal 10 MB.
                </div>
            </v-card-text>

            <v-divider />

            <v-card-actions class="pa-4">
                <v-spacer />

                <v-btn variant="text" :disabled="loading" @click="closeDialog">
                    Batal
                </v-btn>

                <v-btn color="primary" :loading="loading" @click="submit">
                    Simpan
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
