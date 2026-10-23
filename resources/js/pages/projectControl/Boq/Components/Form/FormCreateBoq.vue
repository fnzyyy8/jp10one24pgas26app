<script setup lang="ts">
import { computed, watch } from 'vue';
import { useFormCreateBoqAction } from '@/pages/projectControl/Boq/Composables/useFormCreateBoqAction';
import type { FormBoqOptions } from '@/pages/projectControl/Boq/Types/boq.type';

const dialog = defineModel<boolean>({ default: false });

const props = withDefaults(
    defineProps<{
        formBoqOptions: FormBoqOptions;
    }>(),
    {
        formBoqOptions: () => ({
            categories: [],
            projects: [],
        }),
    },
);

const projectsRef = computed(() => props.formBoqOptions.projects);

const {
    formCreate,
    selectedCategory,
    filteredProjects,
    resetCreateForm,
    submitCreateForm,
} = useFormCreateBoqAction(projectsRef, () => {
    dialog.value = false;
});

watch(dialog, (isOpen) => {
    if (!isOpen) {
        resetCreateForm();
    }
});
</script>

<template>
    <v-dialog v-model="dialog" width="700">
        <v-card>
            <v-form @submit.prevent="submitCreateForm">
                <div class="flex flex-col gap-5 p-3">
                    <div>
                        <h1>Create Boq</h1>
                    </div>
                    <div class="flex flex-col">
                        <v-autocomplete
                            v-model="selectedCategory"
                            :items="props.formBoqOptions.categories"
                            label="Category"
                        />
                        <v-autocomplete
                            v-model="formCreate.project_id"
                            :items="filteredProjects"
                            :disabled="!selectedCategory"
                            :error-messages="formCreate.errors.project_id"
                            item-title="project_name"
                            item-value="id"
                            label="Project"
                            variant="outlined"
                            density="comfortable"
                            clearable
                        />
                        <v-text-field
                            v-model="formCreate.detailed_area"
                            :error-messages="formCreate.errors.detailed_area"
                            label="Detailed Area"
                            variant="outlined"
                            density="comfortable"
                        />

                        <v-checkbox
                            v-model="formCreate.isMultipleCustomer"
                            :error-messages="
                                formCreate.errors.isMultipleCustomer
                            "
                            :false-value="false"
                            :true-value="true"
                            label="Cakupan area lebih dari satu"
                        />
                    </div>
                    <div class="flex justify-end gap-3">
                        <v-btn
                            color="success"
                            type="submit"
                            :loading="formCreate.processing"
                            >Submit</v-btn
                        >
                        <v-btn
                            color="error"
                            @click="dialog = false"
                            :disabled="formCreate.processing"
                            >Batal</v-btn
                        >
                    </div>
                </div>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<style scoped></style>
