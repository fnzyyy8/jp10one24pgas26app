<script setup lang="ts">
import { usePlanFilterActions } from '@/pages/projectControl/Plan/Composables/usePlanFilterActions';
import type { Boq } from '@/pages/projectControl/Plan/Types/plan.type';

const dialog = defineModel<boolean>({ default: false });

defineProps<{
    boq: Boq;

}>();

const {
    selectedCustomer,
    selectedSection,
    selectedCategory,
    selectedSubCategory,
    activeFilterCount,
    resetFilter,
} = usePlanFilterActions();
</script>

<template>
    <v-dialog v-model="dialog" width="750">
        <v-card>
            <div class="p-3">
                <div><h1>Filter</h1></div>
                <div class="my-3">
                    <v-autocomplete
                        v-model="selectedCustomer"
                        :items="[
                            'Rumah Tangga',
                            'Pelanggan Kecil',
                            'Komersial Industri',
                        ]"
                        density="comfortable"
                        variant="outlined"
                        label="Jenis Pelanggan"
                        chips
                        multiple
                        closable-chips
                    />
                    <v-autocomplete
                        v-model="selectedSection"
                        :items="[
                            'Rumah Tangga',
                            'Pelanggan Kecil',
                            'Komersial Industri',
                        ]"
                        density="comfortable"
                        variant="outlined"
                        label="Section"
                        chips
                        multiple
                        closable-chips
                    />
                    <v-autocomplete
                        v-model="selectedCategory"
                        :items="[
                            'Rumah Tangga',
                            'Pelanggan Kecil',
                            'Komersial Industri',
                        ]"
                        density="comfortable"
                        variant="outlined"
                        label="Category"
                        chips
                        multiple
                        closable-chips
                    />
                    <v-autocomplete
                        v-model="selectedSubCategory"
                        :items="[
                            'Rumah Tangga',
                            'Pelanggan Kecil',
                            'Komersial Industri',
                        ]"
                        density="comfortable"
                        variant="outlined"
                        label="Sub Category"
                        chips
                        multiple
                        closable-chips
                    />
                </div>
                <div class="flex justify-end gap-3">
                    <v-btn
                        prepend-icon="mdi-filter-outline"
                        variant="outlined"
                        color="primary"
                    >
                        Filter
                        <span v-if="activeFilterCount > 0"
                            >({{ activeFilterCount }})</span
                        >
                    </v-btn>

                    <v-btn
                        prepend-icon="mdi-reload"
                        text="Reset"
                        variant="outlined"
                        color="grey"
                        @click="resetFilter"
                    />
                </div>
            </div>
        </v-card>
    </v-dialog>
</template>

<style scoped></style>
