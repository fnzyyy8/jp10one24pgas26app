<script setup lang="ts">
import type {
    Boq,
    ItemDetail,
} from '@/pages/projectControl/PlanDetail/Types/plan.detail';

defineProps<{
    boq: Boq;
    itemDetail: ItemDetail;
}>();

</script>

<template>
    <v-card>
        <div class="flex flex-col gap-3 p-3">
            <div class="grid grid-cols-3">
                <div>
                    <span>Section : </span>
                    <h3>{{ itemDetail.section }}</h3>
                </div>
                <div>
                    <span>Kategori : </span>
                    <h3>{{ itemDetail.category }}</h3>
                </div>
                <div>
                    <span>Sub Kategori : </span>
                    <h3>{{ itemDetail.subCategory }}</h3>
                </div>
            </div>
            <v-divider />
            <div class="min-h-32">
                <span>Nama Pekerjaan : </span>
                <h3>{{ itemDetail.name }}</h3>
            </div>
        </div>
    </v-card>
</template>

<style scoped>
span {
    color: #90a4ae;
}
</style>
