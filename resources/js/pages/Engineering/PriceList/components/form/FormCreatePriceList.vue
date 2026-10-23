<script setup lang="ts">
import { usePriceListCreateActions } from '@/pages/Engineering/PriceList/composables/usePriceListCreateActions';

const dialog = defineModel<boolean>({ default: false });

const { formCreate, submitCreate } = usePriceListCreateActions(() => {
    dialog.value = false;
});
</script>

<template>
    <v-dialog v-model="dialog" width="700">
        <v-card>
            <v-form @submit.prevent="submitCreate">
                <div class="flex flex-col gap-3 p-3">
                    <div>
                        <h1>Tambahkan Harga Satuan</h1>
                    </div>
                    <div class="flex flex-col">
                        <v-text-field
                            v-model="formCreate.name"
                            :error-messages="formCreate.errors.name"
                            label="Nama Harsat"
                        />
                        <v-text-field
                            v-model="formCreate.number"
                            :error-messages="formCreate.errors.number"
                            label="Nomor Harsat"
                        />
                        <v-text-field
                            v-model="formCreate.client"
                            :error-messages="formCreate.errors.client"
                            label="Client"
                        />
                    </div>
                    <div class="flex justify-end gap-2">
                        <v-btn
                            text="Submit"
                            color="success"
                            variant="elevated"
                            type="submit"
                            :loading="formCreate.processing"
                        />
                        <v-btn
                            text="Close"
                            color="error"
                            variant="elevated"
                            :disabled="formCreate.processing"
                            @click="dialog = false"
                        />
                    </div>
                </div>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<style scoped></style>
