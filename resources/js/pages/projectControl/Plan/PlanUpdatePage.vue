<script setup lang="ts">
import { onMounted } from 'vue';
import AppCardSave from '@/components/card/AppCardSave.vue';
import { useBreadcrumb } from '@/composable/useBreadcrumb';
import PlanUpdateTable from '@/pages/projectControl/Plan/Components/Table/PlanUpdateTable.vue';
import { useUpdatePlanActions } from '@/pages/projectControl/Plan/Composables/useUpdatePlanActions';
import type {
    Boq,
    Section,
} from '@/pages/projectControl/Plan/Types/plan.type';
import { route } from 'ziggy-js';

const { setBreadcrumbs } = useBreadcrumb();
onMounted(() => {
    setBreadcrumbs([
        {
            title: 'BOQ',
            href: route('boq'),
        },
        {
            title: 'PLAN',
            href: route('plan.index', props.boq.id),
        },
        {
            title: 'UPDATE PLAN',
            disabled: true,
        },
    ]);
});

const props = defineProps<{
    boq: Boq;
    sections: Section[];
    plans: any;
}>();

const {
    selectedItemIds,
    isAllSelected,
    isIndeterminate,
    hasChange,
    isSaving,
    handleSave,
} = useUpdatePlanActions(
    () => props.boq.id,
    () => props.sections,
    () => props.plans,
);
</script>

<template>
    <div class="flex flex-col gap-3">
        <AppCardSave
            :is-saving="isSaving"
            :has-change="hasChange"
            @save="handleSave"
        >
            <div>
                <div class="">
                    <div class="mb-3">
                        <span>Nama Proyek</span>
                        <h1>{{ boq.project_name }}</h1>
                    </div>
                    <div class="flex gap-5">
                        <div>
                            <span>Nomor SPK</span>
                            <h3>{{ boq.project_number }}</h3>
                        </div>
                        <v-divider vertical />
                        <div>
                            <span>Client</span>
                            <h3>{{ boq.client }}</h3>
                        </div>
                        <v-divider vertical />
                        <div>
                            <span>Area</span>
                            <h3>{{ boq.area }}</h3>
                        </div>
                        <v-divider vertical />
                        <div>
                            <span>Detail Area</span>
                            <h3>{{ boq.detailed_area }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </AppCardSave>
        <PlanUpdateTable
            :sections="sections"
            v-model:selectedIds="selectedItemIds"
            v-model:is-all-selected="isAllSelected"
            :is-indeterminate="isIndeterminate"
        />
    </div>
</template>

<style scoped></style>
