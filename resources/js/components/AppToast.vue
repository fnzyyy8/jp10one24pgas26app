<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';

import { watch } from 'vue';
import { useToastStore } from '@/stores/useToastStore';
import type { PageProps } from '@/types';

const page = usePage<PageProps>();
const toast = useToastStore();

watch(
    () =>
        page.props.flash as { success?: string; error?: string; info: string },
    (flash) => {
        if (flash?.success) {
            toast.success(flash.success);
        }

        if (flash?.error) {
            toast.error(flash.error);
        }

        if (flash?.info) {
            toast.info(flash.info);
        }
    },
    {
        deep: true,
        immediate: true,
    },
);
</script>

<template>
    <Transition name="fade">
        <div v-if="toast.visible" class="fixed right-4 bottom-4 z-50 max-w-sm">
            <v-alert
                :text="toast.message"
                :type="toast.type"
                closable
                @click:close="toast.hide()"
            />
        </div>
    </Transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
