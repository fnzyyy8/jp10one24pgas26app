<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import HeadMenu from '@/Layouts/HeadMenu.vue';
import type { PageProps } from '@/types';

const page = usePage<PageProps>();
const isLoggedIn = computed(() => !!(page.props.auth as any)?.user);
</script>

<template>
    <div class="error-layout-container">
        <header v-if="isLoggedIn" class="error-header">
            <HeadMenu />
        </header>
        <main class="error-body">
            <slot />
        </main>
    </div>
</template>

<style scoped>
.error-layout-container {
    display: flex;
    flex-direction: column;
    width: 100vw;
    height: 100vh;
    background: #f4f7fb;
    overflow: hidden;
}

.error-header {
    flex: 0 0 64px;
    background: #17365d;
}

.error-body {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow-y: auto;
}
</style>
