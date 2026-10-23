<script setup lang="ts">
import { toRef } from 'vue';
import { useUpdateItemDetailActions } from '@/pages/Engineering/ItemDetail/composables/useUpdateItemDetailActions';
import type { ItemDetail } from '@/pages/Engineering/ItemDetail/types/item-detail.type';

const dialog = defineModel<boolean>({ default: false });
const props = defineProps<{
    itemDetailId: ItemDetail | null;
}>();

const itemDetailRef = toRef(props, 'itemDetailId');

const { formUpdate, submitUpdate } = useUpdateItemDetailActions(
    itemDetailRef,
    () => {
        dialog.value = false;
    },
);

const closeDialog = () => {
    dialog.value = false;
    formUpdate.reset();
};
</script>

<template>
    <v-dialog v-model="dialog" width="750">
        <v-form @submit.prevent="submitUpdate">
            <v-card>
                <div class="p-3">
                    <div class="mb-3">
                        <h1>Update Item Detail</h1>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <v-text-field
                            class="col-span-2"
                            density="comfortable"
                            variant="outlined"
                            v-model="formUpdate.name"
                            :error-messages="formUpdate.errors.name"
                        />
                        <v-text-field
                            density="comfortable"
                            variant="outlined"
                            v-model="formUpdate.unit"
                            :error-messages="formUpdate.errors.unit"
                        />
                        <v-number-input
                            density="comfortable"
                            variant="outlined"
                            v-model="formUpdate.sort_order"
                            controlVariant="hidden"
                            :error-messages="formUpdate.errors.sort_order"
                        />
                    </div>
                    <div class="flex justify-end gap-3">
                        <v-btn color="success" text="Submit" type="submit" />
                        <v-btn
                            color="error"
                            text="Batal"
                            @click="closeDialog"
                        />
                    </div>
                </div>
            </v-card>
        </v-form>
    </v-dialog>
</template>

<style scoped></style>
