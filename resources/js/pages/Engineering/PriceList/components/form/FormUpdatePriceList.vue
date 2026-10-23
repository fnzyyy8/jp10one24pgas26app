<script setup lang="ts">
import { toRef } from 'vue';
import { usePriceListUpdateActions } from '@/pages/Engineering/PriceList/composables/usePriceListUpdateActions';
import type { PriceList } from '@/pages/Engineering/PriceList/type/price-list.type';

const dialog = defineModel<boolean>({ default: false });

const props = defineProps<{
    priceList: PriceList | null;
}>();

const priceListRef = toRef(props, 'priceList');

const { formUpdate, submitUpdate } = usePriceListUpdateActions(
    priceListRef,
    () => {
        dialog.value = false;
    },
);
</script>

<template>
    <v-dialog v-model="dialog" width="700">
        <v-card>
            <v-form @submit.prevent="submitUpdate">
                <div class="flex flex-col gap-3 p-3">
                    <div>
                        <h1>Tambahkan Harga Satuan</h1>
                    </div>
                    <div class="flex flex-col">
                        <v-text-field
                            v-model="formUpdate.name"
                            :error-messages="formUpdate.errors.name"
                            variant="outlined"
                            density="comfortable"
                            label="Nama Harsat"
                        />
                        <v-text-field
                            v-model="formUpdate.number"
                            :error-messages="formUpdate.errors.number"
                            variant="outlined"
                            density="comfortable"
                            label="Nomor Harsat"
                        />
                        <v-text-field
                            v-model="formUpdate.client"
                            :error-messages="formUpdate.errors.client"
                            variant="outlined"
                            density="comfortable"
                            label="Client"
                        />
                    </div>
                    <div class="flex justify-end gap-2">
                        <v-btn
                            text="Submit"
                            color="success"
                            variant="elevated"
                            type="submit"
                            :loading="formUpdate.processing"
                        />
                        <v-btn
                            text="Close"
                            color="error"
                            variant="elevated"
                            :disabled="formUpdate.processing"
                            @click="dialog = false"
                        />
                    </div>
                </div>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<style scoped></style>
