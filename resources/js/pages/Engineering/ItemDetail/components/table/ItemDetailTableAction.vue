<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const formDelete = useForm({});
const props = defineProps<{
    itemDetailId: number;
}>();
const handleDelete = () => {
    formDelete.delete(route('item-details.delete', props.itemDetailId));
};

const emit = defineEmits<{
    (e: 'update-item-detail'): void;
}>();
</script>

<template>
    <v-menu>
        <template v-slot:activator="{ props }">
            <v-btn icon="mdi-dots-vertical" variant="text" v-bind="props" />
        </template>

        <v-list>
            <v-list-item
                prepend-icon="mdi-pencil"
                base-color="warning"
                title="Edit"
                @click="emit('update-item-detail')"
            />
            <v-list-item
                prepend-icon="mdi-delete"
                base-color="error"
                title="Delete"
                @click="handleDelete"
            />
        </v-list>
    </v-menu>
</template>

<style scoped></style>
