<script setup lang="ts">
import { computed, onMounted } from 'vue';
import BaseLineChart from '@/components/chart/BaseLineChart.vue';
import { useBreadcrumb } from '@/composable/useBreadcrumb';
import { useRecordPriceActions } from '@/pages/Engineering/PriceListDetail/composables/useRecordPriceActions';
import FormCreateRecordPrice from '@/pages/Engineering/RecordPrice/components/form/FormCreateRecordPrice.vue';
import RecordPriceInformation from '@/pages/Engineering/RecordPrice/components/RecordPriceInformation.vue';
import RecordPriceTable from '@/pages/Engineering/RecordPrice/components/RecordPriceTable.vue';
import type {
    RecordPrice,
    UnitPrice,
} from '@/pages/Engineering/RecordPrice/types/record-price.type';
import { route } from 'ziggy-js';

const props = defineProps<{
    priceList: any;
    recordPrices: RecordPrice[];
    unitPrice: UnitPrice;
}>();
const { setBreadcrumbs } = useBreadcrumb();

const chartData = computed(() => {
    if (!props.recordPrices || !Array.isArray(props.recordPrices)) {
        return [];
    }

    return props.recordPrices.map((item: RecordPrice) => ({
        date: item.date,
        price: Number(item.price),
    }));
});
onMounted(() => {
    setBreadcrumbs([
        {
            title: 'HARSAT',
            href: route('price-list.index'),
        },
        {
            title: 'DETAIL HARSAT',
            href: route('price-list.show', { id: props.priceList.id }),
        },
        {
            title: 'RECORD PRICE',
            disabled: true,
        },
    ]);
});

const { isCreateOpen, openCreateDialog, submitDelete } = useRecordPriceActions(
    props.priceList.id,
);
</script>

<template>
    <FormCreateRecordPrice
        v-model="isCreateOpen"
        :unitPrice="unitPrice"
        :priceList="priceList"
    />
    <div>
        <div class="grid gap-3">
            <RecordPriceInformation
                :unitPrice="unitPrice"
                :priceList="priceList"
            />
            <div class="grid grid-cols-2 gap-3">
                <BaseLineChart :data="chartData" :height="370" />
                <RecordPriceTable
                    @open-create-dialog="openCreateDialog"
                    @delete-record-price="(id) => submitDelete(id)"
                    :recordPrices="recordPrices"
                />
            </div>
        </div>
    </div>
</template>

<style scoped></style>
