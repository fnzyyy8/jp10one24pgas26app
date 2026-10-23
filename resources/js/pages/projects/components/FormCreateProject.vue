<script setup lang="ts">
import { ref } from 'vue';
import { VTextField } from 'vuetify/components';

import AppDatePicker from '@/components/AppDatePicker.vue';
import { useProjectCreateActions } from '@/pages/projects/composables/useProjectCreateActions';
import type { PriceListOption } from '@/pages/projects/types';

const dialog = ref(false);
defineProps<{
    priceListOptions: PriceListOption[];
}>();

const { form, submitForm, loading, dateStart, dateEnd, minDateEnd } =
    useProjectCreateActions(() => {
        dialog.value = false;
    });
</script>

<template>
    <v-dialog
        max-width="700"
        transition="dialog-center-transition"
        v-model="dialog"
    >
        <v-card>
            <v-form @submit.prevent="submitForm" id="project-form">
                <v-card-title>
                    <span>Buat Project</span>
                </v-card-title>
                <v-spacer />

                <v-card-item>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="col-span-2 mt-2">
                            <v-autocomplete
                                v-model="form.price_list_id"
                                :items="priceListOptions"
                                item-title="name"
                                item-value="id"
                                variant="outlined"
                                density="comfortable"
                                clearable
                            />
                        </div>
                        <div class="mt-2">
                            <v-text-field
                                v-model="form.project_code"
                                density="comfortable"
                                variant="outlined"
                                label="Kode Proyek"
                                :error-messages="form.errors.project_code"
                            />
                        </div>
                        <div class="mt-2">
                            <v-text-field
                                v-model="form.project_number"
                                density="comfortable"
                                variant="outlined"
                                label="Nomor SPK"
                                :error-messages="form.errors.project_number"
                            />
                        </div>
                        <div class="col-span-2">
                            <v-combobox
                                v-model="form.category"
                                density="comfortable"
                                variant="outlined"
                                :items="['Material', 'Konstruksi']"
                                label="Kategori Proyek"
                                :error-messages="form.errors.category"
                            />
                        </div>

                        <div class="col-span-2">
                            <v-textarea
                                v-model="form.project_name"
                                density="comfortable"
                                variant="outlined"
                                label="Nama Proyek"
                                :error-messages="form.errors.project_name"
                            />
                        </div>
                        <div class="col-span-2">
                            <v-number-input
                                v-model="form.budget"
                                density="comfortable"
                                variant="outlined"
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
                                v-model="form.area"
                                density="comfortable"
                                variant="outlined"
                                label="Area"
                                :error-messages="form.errors.area"
                            />
                        </div>
                        <div>
                            <AppDatePicker
                                v-model="dateStart"
                                label="Tanggal Mulai"
                            />
                            <span
                                v-if="form.errors.start_date"
                                class="text-sm text-red-500"
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
                                class="text-sm text-red-500"
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
