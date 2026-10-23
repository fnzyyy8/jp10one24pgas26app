<script setup lang="ts">
import { ref } from 'vue';
import { useUpdatePassword } from '@/pages/Auth/composables/useUpdatePassword';

const { passwordForm, updatePassword } = useUpdatePassword();

const showCurrentPassword = ref(false);
const showNewPassword = ref(false);
const showPasswordConfirmation = ref(false);
</script>

<template>
    <v-card class="profile-card password-card" rounded="xl" elevation="0">
        <!-- Card Header -->
        <div class="card-heading">
            <div class="heading-icon">
                <v-icon icon="mdi-shield-lock-outline" size="24" />
            </div>

            <div class="heading-content">
                <h2>Change Password</h2>
                <p>Keep your account secure with a strong password.</p>
            </div>
        </div>

        <v-divider class="card-divider" />

        <!-- Success Message -->
        <v-alert
            v-if="passwordForm.recentlySuccessful"
            class="success-alert mb-5"
            type="success"
            variant="tonal"
            rounded="lg"
            density="comfortable"
        >
            Password updated successfully.
        </v-alert>

        <!-- Password Form -->
        <v-form @submit.prevent="updatePassword">
            <div class="password-fields">
                <!-- Current Password -->
                <div class="form-field">
                    <label for="current-password"> Current Password </label>

                    <v-text-field
                        id="current-password"
                        v-model="passwordForm.current_password"
                        :type="showCurrentPassword ? 'text' : 'password'"
                        :append-inner-icon="
                            showCurrentPassword
                                ? 'mdi-eye-off-outline'
                                : 'mdi-eye-outline'
                        "
                        prepend-inner-icon="mdi-lock-outline"
                        placeholder="Enter current password"
                        autocomplete="current-password"
                        variant="outlined"
                        density="comfortable"
                        rounded="lg"
                        class="password-input"
                        :error-messages="passwordForm.errors.current_password"
                        :disabled="passwordForm.processing"
                        hide-details="auto"
                        @click:append-inner="
                            showCurrentPassword = !showCurrentPassword
                        "
                    />
                </div>

                <!-- New Password -->
                <div class="form-field">
                    <label for="new-password"> New Password </label>

                    <v-text-field
                        id="new-password"
                        v-model="passwordForm.password"
                        :type="showNewPassword ? 'text' : 'password'"
                        :append-inner-icon="
                            showNewPassword
                                ? 'mdi-eye-off-outline'
                                : 'mdi-eye-outline'
                        "
                        prepend-inner-icon="mdi-lock-plus-outline"
                        placeholder="Enter new password"
                        autocomplete="new-password"
                        variant="outlined"
                        density="comfortable"
                        rounded="lg"
                        class="password-input"
                        :error-messages="passwordForm.errors.password"
                        :disabled="passwordForm.processing"
                        hide-details="auto"
                        @click:append-inner="showNewPassword = !showNewPassword"
                    />
                </div>

                <!-- Confirm Password -->
                <div class="form-field">
                    <label for="password-confirmation">
                        Confirm New Password
                    </label>

                    <v-text-field
                        id="password-confirmation"
                        v-model="passwordForm.password_confirmation"
                        :type="showPasswordConfirmation ? 'text' : 'password'"
                        :append-inner-icon="
                            showPasswordConfirmation
                                ? 'mdi-eye-off-outline'
                                : 'mdi-eye-outline'
                        "
                        prepend-inner-icon="mdi-lock-check-outline"
                        placeholder="Confirm new password"
                        autocomplete="new-password"
                        variant="outlined"
                        density="comfortable"
                        rounded="lg"
                        class="password-input"
                        :error-messages="
                            passwordForm.errors.password_confirmation
                        "
                        :disabled="passwordForm.processing"
                        hide-details="auto"
                        @click:append-inner="
                            showPasswordConfirmation = !showPasswordConfirmation
                        "
                    />
                </div>
            </div>

            <!-- Password Guidance -->
            <div class="password-guidance">
                <v-icon icon="mdi-information-outline" size="19" />

                <span>
                    Use a strong password that you have not used before.
                </span>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <v-btn
                    class="update-button"
                    type="submit"
                    rounded="lg"
                    prepend-icon="mdi-shield-check-outline"
                    :loading="passwordForm.processing"
                    :disabled="passwordForm.processing"
                >
                    Update Password
                </v-btn>
            </div>
        </v-form>
    </v-card>
</template>

<style scoped>
/* Main Card */
.profile-card {
    width: 100%;
    border: 1px solid #dce4ee;
    background: #ffffff;
    color: #263548;
    box-shadow: 0 4px 16px rgb(23 54 93 / 6%);
}

.password-card {
    padding: 28px;
}

/* Card Header */
.card-heading {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 22px;
}

.heading-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    flex-shrink: 0;
    border: 1px solid #dce6f1;
    border-radius: 13px;
    background: #eaf0f8;
    color: #17365d;
}

.heading-content {
    min-width: 0;
}

.card-heading h2 {
    color: #17365d;
    font-size: 1.2rem;
    font-weight: 700;
    line-height: 1.5;
}

.card-heading p {
    margin-top: 5px;
    color: #5b6878;
    font-size: 0.85rem;
    line-height: 1.6;
}

/* Divider */
.card-divider {
    margin-bottom: 24px;
    border-color: #e4eaf1;
    opacity: 1;
}

/* Password Fields */
.password-fields {
    display: grid;
    gap: 20px;
}

.form-field {
    min-width: 0;
}

.form-field label {
    display: block;
    margin-bottom: 8px;
    color: #17365d;
    font-size: 0.9rem;
    font-weight: 600;
    line-height: 1.5;
}

/* Input Styling */
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

.password-input :deep(.v-field:hover .v-field__outline) {
    color: #8296b0;
}

.password-input :deep(.v-field--focused .v-field__outline) {
    color: #17365d;
}

.password-input :deep(.v-field--disabled) {
    background: #f0f3f7;
    opacity: 0.7;
}

/* Validation Errors */
.password-input :deep(.v-field--error .v-field__outline) {
    color: #b42318;
}

.password-input :deep(.v-field--error .v-field__prepend-inner > .v-icon),
.password-input :deep(.v-field--error .v-field__append-inner > .v-icon) {
    color: #b42318;
}

.password-input :deep(.v-messages__message) {
    overflow-wrap: anywhere;
    font-size: 0.78rem;
    line-height: 1.5;
}

/* Password Guidance */
.password-guidance {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-top: 22px;
    padding: 14px;
    border: 1px solid #dce6f1;
    border-radius: 10px;
    background: #f4f7fb;
    color: #526781;
    font-size: 0.82rem;
    line-height: 1.6;
}

.password-guidance .v-icon {
    flex-shrink: 0;
    margin-top: 1px;
    color: #17365d;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 24px;
}

.update-button {
    min-width: 180px;
    min-height: 46px;
    border: 1px solid #e5ac16;
    background: #e5ac16;
    color: #17365d;
    font-weight: 700;
    letter-spacing: normal;
    text-transform: none;
    transition:
        background-color 0.2s ease,
        border-color 0.2s ease;
}

.update-button:hover {
    border-color: #d19b0d;
    background: #ffda66;
    color: #17365d;
}

.update-button:focus-visible {
    outline: 2px solid #17365d;
    outline-offset: 3px;
}

/* Success Message */
.success-alert {
    border: 1px solid #b8dec7;
}

/* Mobile */
@media (max-width: 600px) {
    .password-card {
        padding: 20px 16px;
    }

    .card-heading {
        align-items: flex-start;
        gap: 12px;
    }

    .heading-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
    }

    .card-heading h2 {
        font-size: 1.05rem;
    }

    .card-heading p {
        font-size: 0.8rem;
    }

    .password-fields {
        gap: 16px;
    }

    .form-field label {
        font-size: 0.85rem;
    }

    .password-input :deep(.v-field),
    .password-input :deep(.v-field__input) {
        min-height: 48px;
    }

    .password-guidance {
        margin-top: 18px;
        padding: 12px;
        font-size: 0.78rem;
    }

    .form-actions {
        justify-content: stretch;
    }

    .update-button {
        width: 100%;
    }
}
</style>
