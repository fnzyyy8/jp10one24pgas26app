<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const props = defineProps<{
    priceListId: number;
    id: number;
}>();

const routeToRecordPrice = () => {
    router.visit(
        route('record.price.index', {
            priceListId: props.priceListId,
            id: props.id,
        }),
    );
};
</script>

<template>
    <v-menu>
        <template #activator="{ props }">
            <v-btn icon="mdi-dots-vertical" variant="text" v-bind="props" />
        </template>

        <v-list>
            <v-list-item
                prepend-icon="mdi-currency-usd"
                base-color="success"
                title="Harga Satuan"
                @click="routeToRecordPrice"
            />
        </v-list>
    </v-menu>
</template>

<style scoped></style>
