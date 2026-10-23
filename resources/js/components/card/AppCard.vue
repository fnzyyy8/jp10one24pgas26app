<script setup lang="ts">
import { computed, ref } from 'vue';

interface ActionItem {
    id: 'create' | 'export' | 'update';
    title: string;
    icon?: string;
    color?: string;
}

const props = withDefaults(
    defineProps<{
        itemId?: number;
        btnLabel?: string;
        showActions?: boolean;
        multipleActions?: boolean;
        activeActions?: ('create' | 'export' | 'update')[];
    }>(),
    {
        showActions: true,
        multipleActions: false,
        activeActions: () => ['create', 'export', 'update'],
    },
);

const isMenuOpen = ref(false);

const emit = defineEmits<{
    (e: 'create'): void;
    (e: 'export'): void;
    (e: 'update', id?: number): void;
}>();

const allAction: Record<string, ActionItem> = {
    create: {
        id: 'create',
        title: 'Create',
        icon: 'mdi-plus',
        color: 'success',
    },
    export: {
        id: 'export',
        title: 'Export',
        icon: 'mdi-file-document-plus-outline',
        color: 'primary',
    },
    update: {
        id: 'update',
        title: 'Update',
        icon: 'mdi-update',
        color: 'success',
    },
};

const visibleActions = computed(() => {
    return props.activeActions.map((key) => allAction[key]).filter(Boolean);
});

const handleActionClick = (actionId: string) => {
    if (actionId === 'create') {
        emit('create');
    }

    if (actionId === 'export') {
        emit('export');
    }

    if (actionId === 'update') {
        emit('update', props.itemId);
    }
};
</script>

<template>
    <v-card class="mb-3">
        <div class="grid grid-cols-3 p-3">
            <div class="col-span-2">
                <slot />
            </div>
            <div v-if="showActions" class="flex items-center justify-end">
                <v-menu
                    v-if="multipleActions"
                    v-model="isMenuOpen"
                    location="bottom end"
                >
                    <template v-slot:activator="{ props: menuProps }">
                        <v-btn
                            prepend-icon="mdi-lightning-bolt"
                            :append-icon="
                                isMenuOpen
                                    ? 'mdi-chevron-up'
                                    : 'mdi-chevron-down'
                            "
                            variant="outlined"
                            color="primary"
                            text="Actions"
                            v-bind="menuProps"
                        />
                    </template>
                    <v-list>
                        <v-list-item
                            v-for="action in visibleActions"
                            :key="action.id"
                            :base-color="action.color"
                            :prepend-icon="action.icon"
                            :title="action.title"
                            @click="handleActionClick(action.id)"
                        />
                    </v-list>
                </v-menu>
                <v-btn-create
                    v-else
                    :text="props.btnLabel"
                    @click="emit('create')"
                />
            </div>
        </div>
    </v-card>
</template>

<style scoped></style>
