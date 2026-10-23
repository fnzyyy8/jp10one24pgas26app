<script setup lang="ts">
import type { UnitPrice } from '@/pages/Engineering/RecordPrice/types/record-price.type';

defineProps<{
    unitPrice: UnitPrice;
    priceList: any;
}>();
</script>

<template>
    <v-card>
        <div class="flex flex-col gap-3 p-3">
            <div class="flex flex-col gap-1">
                <div class="grid grid-rows-2 gap-3">
                    <div>
                        <span>Harsat :</span>
                        <h3>{{ priceList.name }}</h3>
                    </div>
                    <div class="flex gap-5">
                        <div>
                            <span>Nomor :</span>
                            <h3>{{ priceList.number }}</h3>
                        </div>
                        <v-divider vertical/>
                        <div>
                            <span>Client :</span>
                            <h3>{{ priceList.client }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <v-divider />
            <div class="grid grid-cols-3">
                <div>
                    <span>Section : </span>
                    <h3>{{ unitPrice.section }}</h3>
                </div>
                <div>
                    <span>Kategori : </span>
                    <h3>{{ unitPrice.category }}</h3>
                </div>
                <div>
                    <span>Sub Kategori : </span>
                    <h3>{{ unitPrice.subCategory }}</h3>
                </div>
            </div>
            <v-divider />
            <div class="min-h-32">
                <span>Nama Pekerjaan : </span>
                <h3>{{ unitPrice.name }}</h3>
            </div>
        </div>
    </v-card>
</template>

<style scoped>
span {
    color: #90a4ae;
}
</style>
