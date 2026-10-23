```vue
<script setup lang="ts">
import { route } from 'ziggy-js';
</script>

<template>
    <div class="page-heading mb-6">
        <div class="heading-spacer"></div>

        <v-btn
            color="primary"
            variant="outlined"
            prepend-icon="mdi-arrow-left"
            rounded="lg"
            class="dashboard-button"
            :href="route('home')"
        >
            Kembali ke Dashboard
        </v-btn>
    </div>
</template>

<style scoped>
.page-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
}

.heading-spacer {
    flex: 1;
    min-width: 0;
}

.dashboard-button {
    min-width: 190px;
    min-height: 44px;
    border: 1px solid #17365d;
    background: #ffffff;
    color: #17365d;
    font-weight: 600;
    letter-spacing: normal;
    text-transform: none;
    transition:
        background-color 0.2s ease,
        border-color 0.2s ease;
}

.dashboard-button:hover {
    border-color: #17365d;
    background: #eaf0f8;
    color: #17365d;
}

.dashboard-button:focus-visible {
    outline: 2px solid #e5ac16;
    outline-offset: 3px;
}

@media (max-width: 600px) {
    .page-heading {
        align-items: stretch;
        gap: 12px;
    }

    .dashboard-button {
        width: 100%;
    }
}
</style>
```
