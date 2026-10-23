<script setup lang="ts">
import AppDatePicker from '@/components/AppDatePicker.vue';
import { useRecordPriceCreateActions } from '@/pages/Engineering/RecordPrice/composables/useRecordPriceCreateActions';

import type { UnitPrice } from '@/pages/Engineering/RecordPrice/types/record-price.type';

const dialog = defineModel<boolean>({ default: false });

const prop = defineProps<{
    unitPrice: UnitPrice;
    priceList: any;
}>();

const { form, date, submitForm } = useRecordPriceCreateActions(
    prop.unitPrice.id,
    prop.priceList.id,
    () => {
        dialog.value = false;
    },
);
</script>

<template>
    <v-dialog v-model="dialog" width="700">
        <v-card>
            <v-form @submit.prevent="submitForm">
                <div class="p-3">
                    <div class="pb-3">
                        <h1>Form Harsat</h1>
                    </div>
                    <div class="flex flex-col gap-1">
                        <AppDatePicker v-model="date" />
                        <VCurrencyInput
                            label="Harga Satuan"
                            v-model="form.price"
                        />
                        <v-textarea
                            label="Deskripsi"
                            v-model="form.notes"
                            :error-messages="form.errors.notes"
                        />
                    </div>
                    <div class="flex justify-end gap-2">
                        <v-btn text="Submit" color="success" type="submit" />
                        <v-btn
                            text="Batal"
                            color="error"
                            @click="dialog = false"
                        />
                    </div>
                </div>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<style scoped></style>
