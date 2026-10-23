<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { route } from 'ziggy-js';
import FormCreateSignature from './components/FormCreateSignature.vue';
import TableSignature from './components/TableSignature.vue';

interface Signature {
    id: number;
    name: string;
    type: string;
    is_default: boolean;
    image_url: string;
    original_filename: string | null;
    created_at: string | null;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface SignaturePagination {
    data: Signature[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    links: PaginationLink[];
}

interface SignatureFilters {
    search: string;
    per_page: number;
    sort_by: string;
    sort_direction: string;
}

const props = defineProps<{
    signatures: SignaturePagination;
    filters: SignatureFilters;
}>();

const isCreateDialogOpen = ref(false);
const search = ref(props.filters.search ?? '');
const perPage = ref(props.filters.per_page ?? 10);
const isLoading = ref(false);

const signatureItems = computed(() => props.signatures.data ?? []);

watch(
    () => props.filters,
    (filters) => {
        search.value = filters.search ?? '';
        perPage.value = filters.per_page ?? 10;
    },
);

function loadSignatures(page = 1): void {
    isLoading.value = true;

    router.get(
        route('signatures.index'),
        {
            page,
            search: search.value,
            per_page: perPage.value,
            sort_by: props.filters.sort_by || 'created_at',
            sort_direction: props.filters.sort_direction || 'desc',
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            onFinish: () => {
                isLoading.value = false;
            },
        },
    );
}

function handleSearch(): void {
    loadSignatures(1);
}

function handlePageChange(page: number): void {
    loadSignatures(page);
}

function handlePerPageChange(value: number | string | null): void {
    if (value === null) {
        return;
    }

    perPage.value = Number(value);
    loadSignatures(1);
}

function handleSaved(): void {
    loadSignatures(props.signatures.current_page || 1);
}

function handleDeleted(): void {
    const currentPage = props.signatures.current_page || 1;
    const totalAfterDelete = props.signatures.total - 1;
    const lastPageAfterDelete = Math.max(
        1,
        Math.ceil(totalAfterDelete / perPage.value),
    );

    loadSignatures(Math.min(currentPage, lastPageAfterDelete));
}
</script>

<template>
    <v-container fluid>
        <div
            class="d-flex align-center justify-space-between ga-4 mb-6 flex-wrap"
        >
            <div>
                <h1 class="text-h5 font-weight-bold">Signature Management</h1>

                <p class="text-body-2 text-medium-emphasis mt-1">
                    Manage your stored signature images.
                </p>
            </div>

            <v-btn
                color="primary"
                prepend-icon="mdi-plus"
                @click="isCreateDialogOpen = true"
            >
                Add Signature
            </v-btn>
        </div>

        <v-card rounded="lg">
            <v-card-text>
                <v-row align="center">
                    <v-col cols="12" md="8">
                        <v-text-field
                            v-model="search"
                            label="Search signatures"
                            placeholder="Search by name or type"
                            prepend-inner-icon="mdi-magnify"
                            variant="outlined"
                            density="comfortable"
                            clearable
                            hide-details
                            @keyup.enter="handleSearch"
                            @click:clear="handleSearch"
                        />
                    </v-col>

                    <v-col cols="12" md="4">
                        <div class="d-flex align-center ga-2">
                            <span class="text-body-2">Rows:</span>

                            <v-select
                                :model-value="perPage"
                                :items="[10, 25, 50, 100]"
                                variant="outlined"
                                density="comfortable"
                                hide-details
                                @update:model-value="handlePerPageChange"
                            />

                            <v-btn
                                icon="mdi-magnify"
                                variant="tonal"
                                aria-label="Search signatures"
                                @click="handleSearch"
                            />
                        </div>
                    </v-col>
                </v-row>
            </v-card-text>

            <v-divider />

            <TableSignature
                :items="signatureItems"
                :loading="isLoading"
                @deleted="handleDeleted"
            />

            <v-divider />

            <v-card-text
                class="d-flex align-center justify-space-between ga-3 flex-wrap"
            >
                <span class="text-body-2 text-medium-emphasis">
                    {{ signatures.total }} signature(s)
                </span>

                <v-pagination
                    :model-value="signatures.current_page"
                    :length="Math.max(1, signatures.last_page)"
                    :disabled="isLoading"
                    density="comfortable"
                    rounded="circle"
                    @update:model-value="handlePageChange"
                />
            </v-card-text>
        </v-card>

        <FormCreateSignature
            v-model="isCreateDialogOpen"
            @saved="handleSaved"
        />
    </v-container>
</template>
