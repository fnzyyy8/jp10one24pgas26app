<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { route } from 'ziggy-js';

type SignatureType = 'approval' | 'verification' | 'authorization' | 'other';

const props = defineProps<{
    modelValue: boolean;
}>();

const emit = defineEmits<{
    (event: 'update:modelValue', value: boolean): void;
    (event: 'saved'): void;
}>();

const isOpen = computed({
    get: () => props.modelValue,
    set: (value: boolean) => emit('update:modelValue', value),
});

const fileInput = ref<File | null>(null);
const previewUrl = ref<string | null>(null);

const form = useForm({
    name: '',
    type: 'approval' as SignatureType,
    is_default: false,
    file: null as File | null,
});

const signatureTypes = [
    { title: 'Approval', value: 'approval' },
    { title: 'Verification', value: 'verification' },
    { title: 'Authorization', value: 'authorization' },
    { title: 'Other', value: 'other' },
];

watch(fileInput, (file) => {
    if (previewUrl.value) {
        URL.revokeObjectURL(previewUrl.value);
    }

    form.file = file;

    previewUrl.value = file ? URL.createObjectURL(file) : null;
});

function closeDialog(): void {
    isOpen.value = false;
}

function resetForm(): void {
    form.reset();
    form.clearErrors();
    fileInput.value = null;

    if (previewUrl.value) {
        URL.revokeObjectURL(previewUrl.value);
        previewUrl.value = null;
    }
}

function submitForm(): void {
    form.post(route('signatures.store'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            resetForm();
            closeDialog();
            emit('saved');
        },
    });
}
</script>

<template>
    <v-dialog v-model="isOpen" max-width="560" persistent>
        <v-card>
            <v-card-title class="text-h6"> Add Signature </v-card-title>

            <v-card-text>
                <v-form @submit.prevent="submitForm">
                    <v-text-field
                        v-model="form.name"
                        label="Signature Name"
                        variant="outlined"
                        :error-messages="form.errors.name"
                        required
                    />

                    <v-select
                        v-model="form.type"
                        :items="signatureTypes"
                        label="Signature Type"
                        variant="outlined"
                        :error-messages="form.errors.type"
                        required
                    />

                    <v-file-input
                        v-model="fileInput"
                        label="Signature Image"
                        accept="image/png,image/jpeg,image/webp"
                        variant="outlined"
                        prepend-icon="mdi-image"
                        :error-messages="form.errors.file"
                        show-size
                        required
                    />

                    <v-img
                        v-if="previewUrl"
                        :src="previewUrl"
                        alt="Signature preview"
                        max-height="160"
                        contain
                        class="mb-4"
                    />

                    <v-checkbox
                        v-model="form.is_default"
                        label="Set as default signature"
                        :error-messages="form.errors.is_default"
                        hide-details="auto"
                    />

                    <v-alert
                        v-if="form.hasErrors"
                        type="error"
                        variant="tonal"
                        class="mb-4"
                    >
                        Please check the form fields and try again.
                    </v-alert>

                    <v-card-actions class="px-0">
                        <v-spacer />

                        <v-btn
                            variant="text"
                            :disabled="form.processing"
                            @click="closeDialog"
                        >
                            Cancel
                        </v-btn>

                        <v-btn
                            type="submit"
                            color="primary"
                            :loading="form.processing"
                        >
                            Save Signature
                        </v-btn>
                    </v-card-actions>
                </v-form>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
