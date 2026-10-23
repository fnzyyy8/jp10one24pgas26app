<script setup lang="ts">
import { toRef } from 'vue';
import { useFormUpdateBoqAction } from '@/pages/projectControl/Boq/Composables/useFormUpdateBoqAction';
import type { Boq } from '@/pages/projectControl/Boq/Types/boq.type';

const dialog = defineModel<boolean>({ default: false });

const props = defineProps<{
    boq: Boq | null;
}>();

const boqRef = toRef(props, 'boq');
const { formUpdate, submitUpdate } = useFormUpdateBoqAction(boqRef, () => {
    dialog.value = false;
});
</script>

<template>
    <v-dialog v-model="dialog" width="700">
        <v-form @submit.prevent="submitUpdate">
            <v-card>
                <div class="flex flex-col gap-5 p-3">
                    <div>
                        <h1>Create Boq</h1>
                    </div>
                    <div class="flex flex-col">
                        <v-text-field
                            v-model="formUpdate.detailed_area"
                            :error-messages="formUpdate.errors.detailed_area"
                            label="Detailed Area"
                            variant="outlined"
                            density="comfortable"
                        />

                        <v-checkbox
                            v-model="formUpdate.isMultipleCustomer"
                            :error-messages="
                                formUpdate.errors.isMultipleCustomer
                            "
                            :false-value="false"
                            :true-value="true"
                            label="Cakupan Pelanggan lebih dari satu"
                        />
                    </div>
                    <div class="flex justify-end gap-3">
                        <v-btn
                            color="success"
                            type="submit"
                            :loading="formUpdate.processing"
                            >Submit</v-btn
                        >
                        <v-btn
                            color="error"
                            @click="dialog = false"
                            :disabled="formUpdate.processing"
                            >Batal</v-btn
                        >
                    </div>
                </div>
            </v-card>
        </v-form>
    </v-dialog>
</template>

<style scoped></style>
