<script setup lang="ts">
import { onMounted } from 'vue';
import AppCard from '@/components/card/AppCard.vue';
import { useBreadcrumb } from '@/composable/useBreadcrumb';
import PriceListDetailTable from '@/pages/Engineering/PriceListDetail/components/table/PriceListDetailTable.vue';
import { usePriceListDetailActions } from '@/pages/Engineering/PriceListDetail/composables/usePriceListDetailActions';
import type {
    PriceList,
    Section,
} from '@/pages/Engineering/PriceListDetail/type/price-list-detail.type';
import { route } from 'ziggy-js';

const { setBreadcrumbs } = useBreadcrumb();

const props = defineProps<{
    priceList: PriceList;
    sections: Section[];
}>();

onMounted(() => {
    setBreadcrumbs([
        {
            title: 'HARSAT',
            href: route('price-list.index'),
        },
        {
            title: 'DETAIL HARSAT',
            disabled: true,
        },
    ]);
});

const { redirectToUnitPrice } = usePriceListDetailActions();
</script>

<template>
    <AppCard
        :multipleActions="true"
        :active-actions="['update']"
        @update="redirectToUnitPrice(priceList.id)"
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
    </AppCard>
    <div class="flex flex-col gap-3">
        <PriceListDetailTable
            :items="props.sections"
            :priceListId="props.priceList.id"
        />
    </div>
</template>

<style scoped>
span{
    color: #90a4ae;
}
</style>
