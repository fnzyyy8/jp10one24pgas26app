```vue
<script setup lang="ts">
import { ref } from 'vue';

withDefaults(
    defineProps<{
        label: string;
        modelValue: string;
        errorMessage?: string;
        placeholder: string;
        autocomplete: string;
        disabled?: boolean;
        hint?: string;
        persistentHint?: boolean;
        required?: boolean;
        prependIcon?: string;
    }>(),
    {
        errorMessage: '',
        disabled: false,
        hint: undefined,
        persistentHint: false,
        required: true,
        prependIcon: 'mdi-lock-outline',
    },
);

const emit = defineEmits<{
    'update:modelValue': [value: string];
}>();

const isVisible = ref(false);
</script>

<template>
    <div class="password-field">
        <label class="field-label">
            {{ label }}
            <span v-if="required" class="required-indicator">*</span>
        </label>

        <v-text-field
            :model-value="modelValue"
            :type="isVisible ? 'text' : 'password'"
            :autocomplete="autocomplete"
            :placeholder="placeholder"
            :prepend-inner-icon="prependIcon"
            :append-inner-icon="
                isVisible ? 'mdi-eye-off-outline' : 'mdi-eye-outline'
            "
            :error-messages="errorMessage"
            :disabled="disabled"
            :hint="hint"
            :persistent-hint="persistentHint"
            :required="required"
            variant="outlined"
            rounded="lg"
            density="comfortable"
            class="password-input"
            @update:model-value="emit('update:modelValue', $event)"
            @click:append-inner="isVisible = !isVisible"
        />
    </div>
</template>

<style scoped>
.password-field {
    width: 100%;
    min-width: 0;
}

.field-label {
    display: block;
    margin-bottom: 8px;
    color: #17365d;
    font-size: 0.9rem;
    font-weight: 600;
    line-height: 1.5;
}

.required-indicator {
    margin-left: 3px;
    color: #b42318;
}

/* Input appearance */
.password-input {
    color: #263548;
}

.password-input :deep(.v-field) {
    min-height: 52px;
    border-radius: 10px;
    background: #ffffff;
}

.password-input :deep(.v-field__outline) {
    color: #c7d2e0;
}

.password-input :deep(.v-field__input) {
    min-height: 52px;
    padding-top: 12px;
    padding-bottom: 12px;
    color: #263548;
    font-size: 0.9rem;
}

.password-input :deep(.v-field__input input::placeholder) {
    color: #7b8796;
    opacity: 1;
}

.password-input :deep(.v-field__prepend-inner > .v-icon),
.password-input :deep(.v-field__append-inner > .v-icon) {
    color: #526781;
    opacity: 1;
}

/* Focus state */
.password-input :deep(.v-field--focused .v-field__outline) {
    color: #17365d;
}

/* Hover state */
.password-input :deep(.v-field:hover .v-field__outline) {
    color: #8296b0;
}

/* Disabled state */
.password-input :deep(.v-field--disabled) {
    background: #f0f3f7;
    opacity: 0.7;
}

/* Hint */
.password-input :deep(.v-messages__message) {
    color: #5b6878;
    font-size: 0.78rem;
    line-height: 1.5;
}

/* Validation error */
.password-input :deep(.v-field--error .v-field__outline) {
    color: #b42318;
}

.password-input :deep(.v-field--error .v-field__prepend-inner > .v-icon),
.password-input :deep(.v-field--error .v-field__append-inner > .v-icon) {
    color: #b42318;
}

.password-input :deep(.v-messages__message) {
    overflow-wrap: anywhere;
}

@media (max-width: 600px) {
    .field-label {
        font-size: 0.85rem;
    }

    .password-input :deep(.v-field),
    .password-input :deep(.v-field__input) {
        min-height: 48px;
    }
}
</style>
```
