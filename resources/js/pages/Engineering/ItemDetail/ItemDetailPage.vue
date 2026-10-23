<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import AppCard from '@/components/card/AppCard.vue';
import { useBreadcrumb } from '@/composable/useBreadcrumb';
import FormCreateItemDetail from '@/pages/Engineering/ItemDetail/components/form/FormCreateItemDetail.vue';
import FormUpdateItemDetail from '@/pages/Engineering/ItemDetail/components/form/FormUpdateItemDetail.vue';
import ItemDetailTable from '@/pages/Engineering/ItemDetail/components/table/ItemDetailTable.vue';
import { useItemDetailActions } from '@/pages/Engineering/ItemDetail/composables/useItemDetailActions';
import type { ItemDetailOptions } from '@/pages/Engineering/ItemDetail/types/item-detail.type';

const { setBreadcrumbs } = useBreadcrumb();

onMounted(() => {
    setBreadcrumbs([
        {
            title: 'ITEM DETAIL',
            disabled: true,
        },
    ]);
});

const page = usePage<{
    itemDetailOptions: ItemDetailOptions;
    itemDetails: any;
}>();

const {
    isCreateOpen,
    isUpdateOpen,
    selectedDetailId,
    openCreateDialog,
    openUpdateDialog,
} = useItemDetailActions();
</script>

<template>
    <FormCreateItemDetail v-model="isCreateOpen" />
    <FormUpdateItemDetail
        v-model="isUpdateOpen"
        :itemDetailId="selectedDetailId"
    />
    <div>
        <AppCard
            btn-icon="mdi-plus"
            btn-label="Create Item"
            @create="openCreateDialog"
        />
        <v-card>
            <div class="p-3">
                <ItemDetailTable
                    @update-item-detail="openUpdateDialog"
                    :items="page.props.itemDetails"
                />
            </div>
        </v-card>
    </div>
</template>

<style scoped></style>
