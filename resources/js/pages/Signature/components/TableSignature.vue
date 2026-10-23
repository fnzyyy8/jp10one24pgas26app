<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { route } from 'ziggy-js';

interface Signature {
    id: number;
    name: string;
    type: string;
    is_default: boolean;
    image_url: string;
    original_filename: string | null;
    created_at: string | null;
}

const props = defineProps<{
    items: Signature[];
    loading?: boolean;
}>();

const emit = defineEmits<{
    (event: 'deleted'): void;
}>();

const failedImages = ref<number[]>([]);
const deletingId = ref<number | null>(null);

watch(
    () => props.items,
    () => {
        failedImages.value = [];
    },
);

function imageFailed(signatureId: number): boolean {
    return failedImages.value.includes(signatureId);
}

function markImageFailed(signatureId: number): void {
    if (!failedImages.value.includes(signatureId)) {
        failedImages.value.push(signatureId);
    }
}

function deleteSignature(signature: Signature): void {
    const confirmed = window.confirm(`Delete signature "${signature.name}"?`);

    if (!confirmed) {
        return;
    }

    deletingId.value = signature.id;

    router.delete(route('signatures.destroy', signature.id), {
        preserveScroll: true,
        onSuccess: () => emit('deleted'),
        onFinish: () => {
            deletingId.value = null;
        },
    });
}
</script>

<template>
    <v-data-table
        :headers="[
            { title: 'Image', key: 'image', sortable: false },
            { title: 'Name', key: 'name' },
            { title: 'Type', key: 'type' },
            { title: 'Default', key: 'is_default' },
            { title: 'Actions', key: 'actions', sortable: false },
        ]"
        :items="props.items"
        :loading="props.loading"
        item-value="id"
        no-data-text="No signatures found"
    >
        <template v-slot:[`item.image`]="{ item }">
            <div class="d-flex align-center justify-center py-2">
                <div
                    class="signature-image-container d-flex align-center justify-center rounded"
                >
                    <v-img
                        v-if="!imageFailed(item.id)"
                        :key="item.image_url"
                        :src="item.image_url"
                        :alt="`Signature: ${item.name}`"
                        width="140"
                        height="60"
                        contain
                        @error="markImageFailed(item.id)"
                    />

                    <div
                        v-else
                        class="d-flex flex-column align-center text-medium-emphasis justify-center"
                    >
                        <v-icon icon="mdi-image-off-outline" />
                        <span class="text-caption"> Image unavailable </span>
                    </div>
                </div>
            </div>
        </template>

        <template v-slot:[`item.type`]="{ item }">
            <v-chip size="small" variant="tonal">
                {{ item.type }}
            </v-chip>
        </template>

        <template v-slot:[`item.is_default`]="{ item }">
            <v-chip v-if="item.is_default" color="success" size="small">
                Default
            </v-chip>

            <span v-else class="text-medium-emphasis"> — </span>
        </template>

        <template v-slot:[`item.actions`]="{ item }">
            <v-btn
                icon="mdi-delete-outline"
                color="error"
                variant="text"
                size="small"
                :loading="deletingId === item.id"
                :disabled="deletingId !== null"
                aria-label="Delete signature"
                @click="deleteSignature(item)"
            />
        </template>
    </v-data-table>
</template>

<style scoped>
.signature-image-container {
    box-sizing: border-box;
    width: 150px;
    min-height: 76px;
    padding: 8px;
    overflow: hidden;
    background-color: #ffffff;
    border: 1px solid #e0e0e0;
}
</style>
