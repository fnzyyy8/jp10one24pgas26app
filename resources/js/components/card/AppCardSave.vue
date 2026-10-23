<script setup lang="ts">
const props = withDefaults(
    defineProps<{
        text?: string;
        icon?: string;
        isSaving: boolean;
        hasChange: boolean;
    }>(),
    {
        text: 'Save',
        icon: 'mdi-content-save',
    },
);

const emit = defineEmits<{
    (e: 'save'): void;
}>();
</script>

<template>
    <v-card class="mb-3">
        <div class="grid grid-cols-2 p-3">
            <div>
                <slot />
            </div>
            <div class="flex items-center justify-end">
                <v-btn
                    :color="props.hasChange ? 'success' : 'grey'"
                    :text="props.hasChange ? props.text : 'Saved'"
                    :prepend-icon="
                        props.hasChange ? props.icon : 'mdi-content-save-check'
                    "
                    :disabled="!props.hasChange"
                    :loading="props.isSaving"
                    @click.prevent="emit('save')"
                />
            </div>
        </div>
    </v-card>
</template>

<style scoped></style>
