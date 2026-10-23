<script setup lang="ts">
import AppDatePicker from '@/components/AppDatePicker.vue';
import { useProjectEditActions } from '@/pages/projects/composables/useProjectEditActions';
import type { PriceListOption } from '@/pages/projects/types';

defineProps<{
    priceListOptions: PriceListOption[];
}>();

const {
    form,
    isEditOpen,
    dateEnd,
    dateStart,
    minDateEnd,
    openEditModal,
    submit,
} = useProjectEditActions();

defineExpose({ openEditModal });
</script>

<template>
    <v-dialog
        max-width="700"
        transition="dialog-center-transition"
        v-model="isEditOpen"
    >
        <v-card>
            <v-form @submit.prevent="submit" id="project-form">
                <v-card-title>
                    <span>Edit Project</span>
                </v-card-title>
                <v-spacer />

                <v-card-item>
                    <div class="mt-3 grid grid-cols-2 gap-2">
                        <div class="col-span-2 mt-2">
                            <v-autocomplete
                                :items="priceListOptions"
                                item-title="name"
                                item-value="id"
                                variant="outlined"
                                density="comfortable"
                                clearable
                                v-model="form.price_list_id"
                                :error-messages="form.errors.price_list_id"
                            />
                        </div>
                        <div>
                            <v-text-field
                                label="Kode Proyek"
                                variant="outlined"
                                density="comfortable"
                                v-model="form.project_code"
                                :error-messages="form.errors.project_code"
                            />
                        </div>
                        <div>
                            <v-text-field
                                label="Nomor SPK"
                                variant="outlined"
                                density="comfortable"
                                v-model="form.project_number"
                                :error-messages="form.errors.project_number"
                            />
                        </div>
                        <div class="col-span-2">
                            <v-textarea
                                variant="outlined"
                                density="comfortable"
                                v-model="form.project_name"
                                label="Nama Proyek"
                                :error-messages="form.errors.project_name"
                            />
                        </div>
                        <div class="col-span-2">
                            <v-number-input
                                variant="outlined"
                                density="comfortable"
                                v-model="form.budget"
                                label="Anggaran"
                                :error-messages="form.errors.budget"
                                prefix="Rp"
                                controlVariant="stacked"
                                grouping="always"
                                inset
                                :min="0"
                            />
                        </div>
                        <div class="col-span-2">
                            <v-text-field
                                variant="outlined"
                                density="comfortable"
                                v-model="form.area"
                                label="Area"
                                :error-messages="form.errors.area"
                            />
                        </div>
                        <div class="col-span-2">
                            <v-text-field
                                label="Client"
                                variant="outlined"
                                density="comfortable"
                                v-model="form.client"
                                :error-messages="form.errors.client"
                            />
                        </div>
                        <div>
                            <AppDatePicker
                                v-model="dateStart"
                                label="Tanggal Mulai"
                            />
                            <span
                                v-if="form.errors.start_date"
                                class="text-red-500"
                                >{{ form.errors.start_date }}</span
                            >
                        </div>
                        <div>
                            <AppDatePicker
                                v-model="dateEnd"
                                label="Tanggal Selesai"
                                :min="minDateEnd"
                            />
                            <span
                                v-if="form.errors.end_date"
                                class="text-red-500"
                                >{{ form.errors.end_date }}</span
                            >
                        </div>
                        <div>
                            <v-checkbox
                                v-model="form.isMultipleArea"
                                label="Cakupan area lebih dari satu"
                                :error-messages="form.errors.isMultipleArea"
                            />
                        </div>
                    </div>
                </v-card-item>
                <v-card-actions class="mx-2 flex justify-end">
                    <div class="flex gap-2">
                        <v-btn
                            text="Simpan"
                            color="success"
                            variant="flat"
                            :loading="form.processing"
                            type="submit"
                        />
                        <v-btn
                            text="Batal"
                            color="error"
                            variant="flat"
                            @click="isEditOpen = false"
                        />
                    </div>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<style scoped></style>
