<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';

import AppDatePicker from '@/components/AppDatePicker.vue';
import WorkerCertificateTable from '@/pages/manPower/Worker/components/Table/WorkerCertificateTable.vue';
import { useWorkerEditActions } from '@/pages/manPower/Worker/composables/useWorkerEditActions';
import type { Worker } from '@/pages/manPower/Worker/types';
import type { WorkerCertificate } from '@/pages/manPower/Worker/types/workerCertificate';
import { useBreadcrumbStore } from '@/stores/useBreadcrumbStore';
import { route } from 'ziggy-js';

interface WorkScopeOption {
    id: number;
    name: string;
}

const props = defineProps<{
    worker: Worker;
    workScopes: WorkScopeOption[];
    certificates: WorkerCertificate[];
}>();

const breadcrumb = useBreadcrumbStore();

const { form, lastFollowUpDate, loading, submitForm } = useWorkerEditActions(
    props.worker,
);

const fileInput = ref<HTMLInputElement | null>(null);
const photoPreview = ref<string | null>(props.worker.photo_url || null);

let objectUrl: string | null = null;

/**
 * Jangan menggunakan `instanceof File` di template.
 * Pemeriksaan ini aman ketika File tidak tersedia saat SSR.
 */
const hasNewPhoto = computed(() => {
    return typeof File !== 'undefined' && form.photo instanceof File;
});

const selectedPhotoName = computed(() => {
    if (!hasNewPhoto.value) {
        return '';
    }

    return form.photo instanceof File ? form.photo.name : '';
});

const openFilePicker = (): void => {
    fileInput.value?.click();
};

const revokePhotoPreview = (): void => {
    if (objectUrl) {
        URL.revokeObjectURL(objectUrl);
        objectUrl = null;
    }
};

const updatePhotoPreview = (): void => {
    revokePhotoPreview();

    if (hasNewPhoto.value && form.photo instanceof File) {
        objectUrl = URL.createObjectURL(form.photo);
        photoPreview.value = objectUrl;

        return;
    }

    photoPreview.value = props.worker.photo_url || null;
};

const handleFileChange = (event: Event): void => {
    const input = event.target as HTMLInputElement;
    const file = input.files?.[0] ?? null;

    if (!file) {
        return;
    }

    const allowedTypes = ['image/png', 'image/jpeg', 'image/webp'];

    if (!allowedTypes.includes(file.type)) {
        form.photo = null;
        form.setError('photo', 'Format foto harus PNG, JPG, JPEG, atau WEBP.');
        input.value = '';
        updatePhotoPreview();

        return;
    }

    if (file.size > 2 * 1024 * 1024) {
        form.photo = null;
        form.setError('photo', 'Ukuran foto maksimal 2 MB.');
        input.value = '';
        updatePhotoPreview();

        return;
    }

    form.clearErrors('photo');
    form.photo = file;

    updatePhotoPreview();

    // Memungkinkan pengguna memilih file yang sama kembali.
    input.value = '';
};

const clearSelectedPhoto = (): void => {
    form.photo = null;
    form.clearErrors('photo');
    updatePhotoPreview();

    if (fileInput.value) {
        fileInput.value.value = '';
    }
};

watch(
    () => props.worker.photo_url,
    (newPhotoUrl) => {
        if (!hasNewPhoto.value) {
            photoPreview.value = newPhotoUrl || null;
        }
    },
);

onMounted(() => {
    breadcrumb.setBreadcrumbs([
        {
            title: 'WORKER',
            disabled: false,
            href: route('worker.index'),
        },
        {
            title: 'EDIT',
            disabled: true,
        },
    ]);
});

onBeforeUnmount(() => {
    revokePhotoPreview();
});
</script>

<template>
    <v-card class="pa-4 pa-md-6 elevation-2 rounded-lg">
        <v-form @submit.prevent="submitForm">
            <div
                class="grid grid-cols-1 gap-6 lg:grid-cols-[320px_minmax(0,1fr)]"
            >
                <!-- Foto Worker -->
                <section class="flex flex-col items-center gap-4">
                    <v-avatar
                        rounded="lg"
                        size="280"
                        class="border-primary elevation-2 border-2 bg-white"
                    >
                        <v-img
                            v-if="photoPreview"
                            :src="photoPreview"
                            alt="Foto Worker"
                            cover
                        />

                        <v-icon
                            v-else
                            icon="mdi-account"
                            size="80"
                            color="grey"
                        />
                    </v-avatar>

                    <input
                        ref="fileInput"
                        type="file"
                        accept="image/png,image/jpeg,image/webp"
                        class="hidden"
                        @change="handleFileChange"
                    />

                    <div class="flex flex-wrap justify-center gap-2">
                        <v-btn
                            type="button"
                            color="primary"
                            variant="outlined"
                            prepend-icon="mdi-camera"
                            @click="openFilePicker"
                        >
                            Pilih Foto
                        </v-btn>

                        <v-btn
                            v-if="hasNewPhoto"
                            type="button"
                            color="error"
                            variant="text"
                            prepend-icon="mdi-close"
                            @click="clearSelectedPhoto"
                        >
                            Batalkan
                        </v-btn>
                    </div>

                    <p
                        v-if="selectedPhotoName"
                        class="max-w-full text-center text-sm break-all"
                    >
                        {{ selectedPhotoName }}
                    </p>

                    <p class="text-medium-emphasis text-center text-xs">
                        PNG, JPG, JPEG, atau WEBP. Maksimal 2 MB.
                    </p>

                    <p
                        v-if="form.errors.photo"
                        class="text-error text-center text-sm"
                    >
                        {{ form.errors.photo }}
                    </p>
                </section>

                <!-- Informasi Worker -->
                <section class="flex min-w-0 flex-col gap-4">
                    <v-text-field
                        v-model="form.id_card_number"
                        label="ID Card Number"
                        prepend-inner-icon="mdi-card-account-details"
                        density="comfortable"
                        variant="outlined"
                        counter
                        maxlength="20"
                        :error-messages="form.errors.id_card_number"
                    />

                    <v-text-field
                        v-model="form.name"
                        label="Name"
                        prepend-inner-icon="mdi-account"
                        density="comfortable"
                        variant="outlined"
                        :error-messages="form.errors.name"
                    />

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <v-text-field
                            v-model="form.based"
                            label="Based"
                            prepend-inner-icon="mdi-map-marker"
                            density="comfortable"
                            variant="outlined"
                            :error-messages="form.errors.based"
                        />

                        <v-text-field
                            v-model="form.phone_number"
                            label="Phone Number"
                            prepend-inner-icon="mdi-phone"
                            density="comfortable"
                            variant="outlined"
                            :error-messages="form.errors.phone_number"
                        />
                    </div>

                    <v-text-field
                        v-model="form.email"
                        label="Email"
                        type="email"
                        prepend-inner-icon="mdi-email"
                        density="comfortable"
                        variant="outlined"
                        :error-messages="form.errors.email"
                    />

                    <v-autocomplete
                        v-model="form.work_scope_ids"
                        :items="workScopes"
                        item-title="name"
                        item-value="id"
                        label="Work Scopes"
                        placeholder="Pilih work scope (opsional)"
                        hint="Bisa memilih lebih dari satu"
                        persistent-hint
                        multiple
                        chips
                        closable-chips
                        clearable
                        density="comfortable"
                        variant="outlined"
                        prepend-inner-icon="mdi-briefcase-outline"
                        :error-messages="form.errors.work_scope_ids"
                    />

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <v-select
                            v-model="form.work_status"
                            :items="['not active', 'active', 'on work']"
                            label="Work Status"
                            prepend-inner-icon="mdi-list-status"
                            density="comfortable"
                            variant="outlined"
                            :error-messages="form.errors.work_status"
                        />

                        <AppDatePicker
                            v-model="lastFollowUpDate"
                            label="Last Follow Up"
                        />
                    </div>

                    <p
                        v-if="form.errors.last_follow_up"
                        class="text-error text-sm"
                    >
                        {{ form.errors.last_follow_up }}
                    </p>

                    <p
                        v-if="form.errors.work_scope_ids"
                        class="text-error text-sm"
                    >
                        {{ form.errors.work_scope_ids }}
                    </p>
                </section>
            </div>
            <div></div>

            <v-divider class="my-6" />

            <div class="mb-3 flex justify-end">
                <v-btn
                    type="submit"
                    color="success"
                    variant="flat"
                    size="large"
                    prepend-icon="mdi-content-save"
                    :loading="loading || form.processing"
                    :disabled="loading || form.processing"
                >
                    Simpan Perubahan
                </v-btn>
            </div>
        </v-form>
        <WorkerCertificateTable
            :worker-id="props.worker.id"
            :initial-certificates="props.certificates"
        />
    </v-card>
</template>
