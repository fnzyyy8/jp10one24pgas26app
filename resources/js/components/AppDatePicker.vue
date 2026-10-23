<script setup lang="ts">
import { computed, ref } from 'vue';
import type { PropType } from 'vue';
import { VTextField } from 'vuetify/components';

const model = defineModel<Date | null>({ default: null });

const props = defineProps({
    label: {
        type: String,
        default: 'Pilih Tanggal',
    },
    min: {
        type: [Date, String] as PropType<Date | string>,
        default: undefined,
    },
    max: {
        type: [Date, String] as PropType<Date | string>,
        default: undefined,
    },
    density: {
        type: String as PropType<VTextField['$props']['density']>,
        default: 'comfortable',
    },
    variant: {
        type: String as PropType<VTextField['$props']['variant']>,
        default: 'outlined',
    },
});

const menu = ref(false);

const formattedDate = computed(() => {
    return model.value ? new Date(model.value).toLocaleDateString('id-ID') : '';
});
</script>

<template>
    <v-menu v-model="menu" :close-on-content-click="false">
        <template v-slot:activator="{ props: menuProps }">
            <v-text-field
                v-model="formattedDate"
                :variant="props.variant"
                :density="props.density"
                :label="props.label"
                prepend-inner-icon="mdi-calendar"
                readonly
                v-bind="menuProps"
            />
        </template>
        <v-date-picker
            v-model="model"
            :min="props.min"
            :max="props.max"
            @update:model-value="menu = false"
            color="primary"
        />
    </v-menu>
</template>

<style scoped></style>
