<script setup lang="ts">
import { useWorkScopeUpdateActions } from '@/pages/manPower/WorkScope/composables/useWorkScopeUpdateActions';

const { dialog, form, loading, openEditModal, submitForm } =
    useWorkScopeUpdateActions();

defineExpose({
    openEditModal,
});
</script>

<template>
    <v-dialog
        max-width="500"
        transition="dialog-center-transition"
        v-model="dialog"
    >
        <v-card>
            <v-form @submit.prevent="submitForm">
                <v-card-title>
                    <span>Edit Work Scope</span>
                </v-card-title>
                <v-card-item>
                    <div class="mt-2">
                        <v-text-field
                            v-model="form.name"
                            density="comfortable"
                            variant="outlined"
                            label="Name"
                            :error-messages="form.errors.name"
                        />
                    </div>
                </v-card-item>
                <v-card-actions class="flex justify-end px-3">
                    <div class="flex gap-3">
                        <v-btn
                            text="Simpan"
                            color="success"
                            variant="flat"
                            :loading="loading"
                            type="submit"
                        />
                        <v-btn
                            text="Batal"
                            color="error"
                            variant="flat"
                            @click="dialog = false"
                        />
                    </div>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<style scoped></style>
