<script setup lang="ts">
interface Props {
    modelValue: boolean;
    itemName?: string;
    loading?: boolean;
    title?: string;
}

withDefaults(defineProps<Props>(), {
    title: 'Konfirmasi Hapus',
    itemName: 'data ini',
    loading: false,
});

const emit = defineEmits<{
    (e: 'update:modelValue', value: boolean): void;
    (e: 'confirm'): void;
    (e: 'cancel'): void;
}>();

const close = () => {
    emit('update:modelValue', false);
    emit('cancel');
};

const handleConfirm = () => {
    emit('confirm');
};
</script>

<template>
    <v-dialog
        :model-value="modelValue"
        @update:model-value="emit('update:modelValue', $event)"
        max-width="500"
        persistent
    >
        <v-card>
            <v-card-title class="flex items-center gap-2 px-4 pt-2 font-bold">
                <v-icon
                    color="warning"
                    icon="mdi-alert-circle-outline"
                    class="mr-2"
                />
                {{ title }}
            </v-card-title>
            <v-card-text class="pt-2">
                Apakah anda yakin ingin menghapus
                <strong>{{ itemName }}</strong> ? Tindakan ini tidak dapat
                dibatalkan
            </v-card-text>
            <v-card-actions class="pa-4 justify-end">
                <v-btn
                    text="Batal"
                    color="grey-darken-1"
                    :disabled="loading"
                    @click="close"
                />
                <v-btn
                    text="Hapus"
                    color="error"
                    :loading="loading"
                    @click="handleConfirm"
                />
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<style scoped></style>
