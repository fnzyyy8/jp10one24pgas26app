<script setup lang="ts">
import { computed } from 'vue';
import AppDatePicker from '@/components/AppDatePicker.vue';
import { useWorkerCreateActions } from '@/pages/manPower/Worker/composables/useWorkerCreateActions';

interface WorkScopeOption {
    id: number;
    name: string;
}

const props = defineProps<{
    workScopes: WorkScopeOption[];
    modelValue: boolean;
}>();

const emit = defineEmits<{
    'update:modelValue': [value: boolean];
}>();

const dialog = computed({
    get: () => props.modelValue,
    set: (value: boolean) => emit('update:modelValue', value),
});

const { form, lastFollowUpDate, submitForm, loading } = useWorkerCreateActions(() => {
    dialog.value = false;
});
</script>

<template>
    <v-dialog
        max-width="600"
        transition="dialog-center-transition"
        v-model="dialog"
    >
        <v-card>
            <v-form @submit.prevent="submitForm">
                <v-card-title>
                    <span>Buat Worker</span>
                </v-card-title>
                <v-card-item>
                    <div class="mt-2 grid grid-cols-2 gap-2">
                        <div class="col-span-2">
                            <v-text-field
                                v-model="form.id_card_number"
                                density="comfortable"
                                variant="outlined"
                                label="ID Card Number (Min 16 digits)"
                                :error-messages="form.errors.id_card_number"
                                counter
                                maxlength="20"
                            />
                        </div>
                        <div class="col-span-2">
                            <v-text-field
                                v-model="form.name"
                                density="comfortable"
                                variant="outlined"
                                label="Name"
                                :error-messages="form.errors.name"
                            />
                        </div>
                        <div>
                            <v-text-field
                                v-model="form.based"
                                density="comfortable"
                                variant="outlined"
                                label="Based"
                                :error-messages="form.errors.based"
                            />
                        </div>
                        <div>
                            <v-text-field
                                v-model="form.phone_number"
                                density="comfortable"
                                variant="outlined"
                                label="Phone Number"
                                :error-messages="form.errors.phone_number"
                            />
                        </div>
                        <div class="col-span-2">
                            <v-text-field
                                v-model="form.email"
                                density="comfortable"
                                variant="outlined"
                                label="Email"
                                type="email"
                                :error-messages="form.errors.email"
                            />
                        </div>
                        <div class="col-span-2">
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
                                :error-messages="form.errors.work_scope_ids"
                            />
                        </div>
                        <div>
                            <v-combobox
                                v-model="form.work_status"
                                :items="['not active', 'active', 'on work']"
                                density="comfortable"
                                variant="outlined"
                                label="Work Status"
                                :error-messages="form.errors.work_status"
                            />
                        </div>
                        <div>
                            <AppDatePicker
                                v-model="lastFollowUpDate"
                                label="Last Follow Up"
                            />
                            <span
                                v-if="form.errors.last_follow_up"
                                class="text-sm text-red-500"
                                >{{ form.errors.last_follow_up }}</span
                            >
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
