<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { useBreadcrumbStore } from '@/stores/useBreadcrumbStore';

const breadcrumbStore = useBreadcrumbStore();
</script>

<template>
    <nav
        v-if="breadcrumbStore.items.length > 0"
        class="breadcrumb-navigation"
        aria-label="Breadcrumb"
    >
        <v-breadcrumbs
            :items="breadcrumbStore.items"
            density="compact"
            class="breadcrumb-list"
        >
            <template #item="{ item }">
                <li class="breadcrumb-item">
                    <Link
                        v-if="item.href && !item.disabled"
                        :href="item.href"
                        class="breadcrumb-link"
                    >
                        {{ item.title }}
                    </Link>

                    <span v-else class="breadcrumb-current" aria-current="page">
                        {{ item.title }}
                    </span>
                </li>
            </template>

            <template #divider>
                <v-icon
                    icon="mdi-chevron-right"
                    size="18"
                    class="breadcrumb-divider"
                />
            </template>
        </v-breadcrumbs>
    </nav>
</template>

<style scoped>
.breadcrumb-navigation {
    display: flex;
    align-items: center;
    width: 100%;
    min-width: 0;
    overflow: hidden;
    background: transparent;
}

.breadcrumb-list {
    display: flex;
    flex-wrap: nowrap;
    width: 100%;
    min-width: 0;
    padding: 0;
    overflow-x: auto;
    overflow-y: hidden;
    background: transparent;
    scrollbar-width: none;
}

.breadcrumb-list::-webkit-scrollbar {
    display: none;
}

.breadcrumb-list :deep(.v-breadcrumbs__prepend) {
    display: none;
}

.breadcrumb-list :deep(.v-breadcrumbs-item) {
    min-width: 0;
}

.breadcrumb-list :deep(.v-breadcrumbs__item) {
    min-width: 0;
}

.breadcrumb-item {
    display: inline-flex;
    align-items: center;
    min-width: 0;
    white-space: nowrap;
}

.breadcrumb-link {
    color: #5b6878;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    transition: color 0.2s ease;
}

.breadcrumb-link:hover {
    color: #17365d;
    text-decoration: underline;
    text-decoration-color: #e5ac16;
    text-underline-offset: 4px;
}

.breadcrumb-link:focus-visible {
    border-radius: 3px;
    outline: 2px solid #e5ac16;
    outline-offset: 3px;
}

.breadcrumb-current {
    max-width: 320px;
    overflow: hidden;
    color: #17365d;
    font-size: 0.85rem;
    font-weight: 700;
    text-overflow: ellipsis;
}

.breadcrumb-divider {
    color: #9aa8b8;
    opacity: 1;
}

@media (max-width: 600px) {
    .breadcrumb-link,
    .breadcrumb-current {
        font-size: 0.78rem;
    }

    .breadcrumb-current {
        max-width: 180px;
    }

    .breadcrumb-divider {
        font-size: 16px;
    }
}
</style>
