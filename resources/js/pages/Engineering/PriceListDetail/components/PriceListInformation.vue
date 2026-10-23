<script setup lang="ts">
import { ref } from 'vue';
import type { PriceList } from '@/pages/Engineering/PriceListDetail/type/price-list-detail.type';

const props = defineProps<{
    priceList: PriceList;
}>();

const isMenuOpen = ref(false);

const emit = defineEmits<{
    (e: 'create-unit-price', priceListId: number): void;
}>();
</script>

<template>
    <v-card>
        <div class="grid grid-cols-2 p-3">
            <div>
                <h1>{{ props.priceList.name }}</h1>
                <div>
                    <span>
                        {{ props.priceList.client }}
                    </span>
                    <span> | </span>
                    <span>
                        {{ props.priceList.number }}
                    </span>
                </div>
            </div>
            <div class="flex items-center justify-end">
                <v-menu
                    v-model="isMenuOpen"
                    location="bottom end"
                    min-width="100%"
                >
                    <template v-slot:activator="{ props: menuProps }">
                        <v-btn
                            prepend-icon="mdi-lightning-bolt"
                            :append-icon="
                                isMenuOpen
                                    ? 'mdi-chevron-up'
                                    : 'mdi-chevron-down'
                            "
                            variant="outlined"
                            text="Action"
                            color="primary"
                            v-bind="menuProps"
                        />
                    </template>
                    <v-list density="compact">
                        <v-list-item
                            prepend-icon="mdi-file-document-plus-outline"
                            title="Export Harsat"
                            base-color="primary"
                        />
                        <v-divider class="my-1" />
                        <v-list-item
                            prepend-icon="mdi-update"
                            title="Update Item"
                            base-color="success"
                            @click="emit('create-unit-price', priceList.id)"
                        />
                    </v-list>
                </v-menu>
            </div>
        </div>
    </v-card>
</template>

<style scoped></style>
