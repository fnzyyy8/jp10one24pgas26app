<script setup lang="ts">
import { onMounted } from 'vue';
import AppCard from '@/components/card/AppCard.vue';
import { useBreadcrumb } from '@/composable/useBreadcrumb';
import FormCreateBoq from '@/pages/projectControl/Boq/Components/Form/FormCreateBoq.vue';
import FormUpdateBoq from '@/pages/projectControl/Boq/Components/Form/FormUpdateBoq.vue';
import BoqTable from '@/pages/projectControl/Boq/Components/Table/BoqTable.vue';

import { useBoqActions } from '@/pages/projectControl/Boq/Composables/useBoqActions';
import type { Boq } from '@/pages/projectControl/Boq/Types/boq.type';

defineProps<{
    boqs: Boq[];
    formBoqOptions?: any;
}>();

const {
    isCreateOpen,
    isUpdateOpen,
    selectedBoq,
    viewProgress,
    viewPlan,
    openCreateDialog,
    openUpdateDialog,
    submitDeleteForm,
} = useBoqActions();

const { setBreadcrumbs } = useBreadcrumb();

onMounted(() => {
    setBreadcrumbs([
        {
            title: 'BOQ',
            disabled: true,
        },
    ]);
});
</script>

<template>
    <FormCreateBoq :formBoqOptions="formBoqOptions" v-model="isCreateOpen" />
    <FormUpdateBoq :boq="selectedBoq" v-model="isUpdateOpen" />
    <AppCard btn-label="Create Boq" @create="openCreateDialog" />
    <BoqTable
        :boqs="boqs"
        @progress="viewProgress"
        @plan="viewPlan"
        @add-boq="openCreateDialog"
        @update-boq="openUpdateDialog"
        @delete-boq="submitDeleteForm"
    />
</template>

<style scoped></style>
