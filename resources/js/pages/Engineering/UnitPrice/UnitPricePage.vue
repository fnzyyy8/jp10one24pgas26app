<script setup lang="ts">
import { onMounted } from 'vue';
import AppCardSave from '@/components/card/AppCardSave.vue';
import { useBreadcrumb } from '@/composable/useBreadcrumb';
import UnitPriceTable from '@/pages/Engineering/UnitPrice/components/table/UnitPriceTable.vue';
import { useUnitPriceActions } from '@/pages/Engineering/UnitPrice/composables/UseUnitPriceActions';
import type {
    PriceList,
    Section,
    UnitPrice,
} from '@/pages/Engineering/UnitPrice/type/unit-price.type';
import { route } from 'ziggy-js';

const props = defineProps<{
    priceList: PriceList;
    unitPrice: UnitPrice[];
    sections: Section[];
}>();

const { setBreadcrumbs } = useBreadcrumb();

onMounted(() => {
    setBreadcrumbs([
        {
            title: 'HARSAT',
            href: route('price-list.index'),
        },
        {
            title: 'DETAIL HARSAT',
            href: route('price-list.show', props.priceList.id),
        },
        {
            title: 'CREATE HARSAT',
            disabled: true,
        },
    ]);
});

const {
    selectedItemIds,
    isAllSelected,
    isIndeterminate,
    hasChange,
    isSaving,
    handleSave,
} = useUnitPriceActions(
    () => props.priceList,
    () => props.unitPrice,
    () => props.sections,
);
</script>

<template>
    <div class="flex flex-col gap-3">
        <AppCardSave
            :is-saving="isSaving"
            :has-change="hasChange"
            @save="handleSave"
        >
            <div class="flex flex-col gap-3">
                <div>
                    <span>Harsat :</span>
                    <h3>{{ priceList.name }}</h3>
                </div>
                <div class="flex gap-5">
                    <div>
                        <span>Client :</span>
                        <h3>{{ priceList.client }}</h3>
                    </div>
                    <v-divider vertical />
                    <div>
                        <span>Nomor :</span>
                        <h3>{{ priceList.number }}</h3>
                    </div>
                </div>
            </div>
        </AppCardSave>
        <UnitPriceTable
            :price-list="priceList"
            :unit-prices="unitPrice"
            :is-indeterminate="isIndeterminate"
            :sections="sections"
            v-model:selectedIds="selectedItemIds"
            v-model:isAllSelected="isAllSelected"
        />
    </div>
</template>

<style scoped></style>
