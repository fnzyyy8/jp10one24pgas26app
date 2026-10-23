<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { useAuthActions } from '@/pages/Auth/composables/useAuthActions';
import type { UserDivision } from '@/pages/UserManagement/type/index.type';
import { route } from 'ziggy-js';

const { formSubmit, submitLoading, submitRegister } = useAuthActions();

const toLogin = () => {
    router.visit(route('login'));
};

const divisionOptions: { title: string; value: UserDivision }[] = [
    {
        title: 'SITE',
        value: 'site',
    },
    {
        title: 'PSCM',
        value: 'pscm',
    },
    {
        title: 'VENDOR',
        value: 'vendor',
    },
];
</script>

<template>
    <GuestLayout>
        <main class="register-page">
            <!-- Pipeline background video -->
            <video
                class="register-background-video"
                autoplay
                muted
                loop
                playsinline
                preload="metadata"
                aria-hidden="true"
            >
                <source src="/videos/register_video.mp4" type="video/mp4" />
            </video>

            <!-- Corporate Blue overlay -->
            <div class="register-background-overlay"></div>

            <div class="register-layout">
                <!-- Brand introduction -->
                <section class="register-introduction">
                    <h1 class="brand-title">
                        One
                        <span>Jargas</span>
                    </h1>

                    <p class="brand-description">
                        Sistem pemantauan dan pengelolaan proyek jaringan gas
                        dalam satu platform terintegrasi.
                    </p>
                </section>

                <!-- Registration form -->
                <section class="register-panel">
                    <v-card class="register-card" elevation="0" rounded="xl">
                        <div class="register-card-header">
                            <h2>Pembuatan Akun</h2>

                            <p>Ajukan permintaan pembuatan akun</p>
                        </div>

                        <v-form
                            class="register-form"
                            @submit.prevent="submitRegister"
                        >
                            <div class="form-field">
                                <label for="register-name">Nama Lengkap</label>

                                <v-text-field
                                    id="register-name"
                                    v-model="formSubmit.name"
                                    placeholder="Masukkan nama lengkap"
                                    prepend-inner-icon="mdi-account-outline"
                                    variant="outlined"
                                    density="comfortable"
                                    rounded="lg"
                                    autocomplete="name"
                                    :error-messages="formSubmit.errors.name"
                                    :disabled="submitLoading"
                                    hide-details="auto"
                                />
                            </div>

                            <div class="form-field">
                                <label for="register-email">Alamat Email</label>

                                <v-text-field
                                    id="register-email"
                                    v-model="formSubmit.email"
                                    placeholder="Contoh: nama@perusahaan.co.id"
                                    prepend-inner-icon="mdi-email-outline"
                                    type="email"
                                    variant="outlined"
                                    density="comfortable"
                                    rounded="lg"
                                    autocomplete="email"
                                    :error-messages="formSubmit.errors.email"
                                    :disabled="submitLoading"
                                    hide-details="auto"
                                />
                            </div>

                            <div class="form-field">
                                <label for="register-division">Divisi</label>

                                <v-combobox
                                    id="register-division"
                                    v-model="formSubmit.division"
                                    :items="divisionOptions"
                                    item-title="title"
                                    item-value="value"
                                    placeholder="Pilih divisi"
                                    prepend-inner-icon="mdi-domain"
                                    density="comfortable"
                                    variant="outlined"
                                    rounded="lg"
                                    :error-messages="formSubmit.errors.division"
                                    :disabled="submitLoading"
                                    hide-details="auto"
                                />
                            </div>

                            <div class="form-field">
                                <label for="register-position">Jabatan</label>

                                <v-combobox
                                    id="register-position"
                                    v-model="formSubmit.position"
                                    :items="[
                                        'Project Control',
                                        'Administration and Contract',
                                        'Finance',
                                        'HSSE',
                                        'QAQC',
                                        'Engineering',
                                        'General Affair',
                                        'Procurement',
                                        'Logistic',
                                    ]"
                                    placeholder="Pilih jabatan"
                                    prepend-inner-icon="mdi-briefcase-outline"
                                    density="comfortable"
                                    variant="outlined"
                                    rounded="lg"
                                    :error-messages="formSubmit.errors.position"
                                    :disabled="submitLoading"
                                    hide-details="auto"
                                />
                            </div>

                            <v-btn
                                class="register-button"
                                type="submit"
                                block
                                size="large"
                                rounded="lg"
                                :loading="submitLoading"
                                :disabled="submitLoading"
                            >
                                <span>Daftar Akun</span>
                            </v-btn>

                            <div class="flex flex-col items-center">
                                <span>Sudah memiliki akun?</span>

                                <v-btn
                                    class="login-link"
                                    variant="text"
                                    size="default"
                                    :disabled="submitLoading"
                                    @click="toLogin"
                                >
                                    Masuk di sini
                                </v-btn>
                            </div>
                        </v-form>
                    </v-card>
                </section>
            </div>

            <footer class="register-footer">
                <span>Dashboard Jargas</span>
                <span class="footer-separator">•</span>
                <span>Gas Pipeline Monitoring System</span>
            </footer>
        </main>
    </GuestLayout>
</template>

<style scoped>
.register-page {
    position: relative;
    isolation: isolate;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    min-height: 100vh;
    min-height: 100dvh;
    overflow: hidden;
    padding: 48px 6vw 72px;
    background: #17365d;
    color: #263548;
}

/* Background video */
.register-background-video {
    position: absolute;
    z-index: -2;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transform: scaleX(-1);
}

/* Keep the form readable */
.register-background-overlay {
    position: absolute;
    z-index: -1;
    inset: 0;
    background:
        linear-gradient(
            90deg,
            rgb(13 37 66 / 88%) 0%,
            rgb(23 54 93 / 78%) 38%,
            rgb(23 54 93 / 60%) 68%,
            rgb(13 37 66 / 70%) 100%
        ),
        linear-gradient(0deg, rgb(13 37 66 / 25%), rgb(13 37 66 / 25%));
}

.register-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(380px, 480px);
    align-items: center;
    gap: clamp(40px, 7vw, 100px);
    width: 100%;
    max-width: 1240px;
    margin: auto;
}

/* Brand introduction */
.register-introduction {
    max-width: 570px;
    color: #ffffff;
}

.brand-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    margin-bottom: 28px;
    border: 1px solid rgb(255 255 255 / 30%);
    border-radius: 16px;
    background: rgb(255 255 255 / 12%);
    color: #ffffff;
}

.brand-label {
    margin-bottom: 12px;
    color: #ffda66;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    line-height: 1.6;
}

.brand-title {
    font-size: clamp(2.5rem, 4.5vw, 4rem);
    font-weight: 800;
    letter-spacing: -1.5px;
    line-height: 1.12;
}

.brand-title span {
    display: block;
    color: #ffda66;
}

.brand-description {
    max-width: 500px;
    margin-top: 22px;
    color: #eef4fb;
    font-size: 1.1rem;
    line-height: 1.8;
}

.brand-features {
    display: flex;
    flex-direction: column;
    gap: 18px;
    margin-top: 36px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #f3f7fc;
    font-size: 0.95rem;
    line-height: 1.5;
}

.feature-item :deep(.v-icon) {
    flex-shrink: 0;
    color: #ffda66;
}

/* Registration card */
.register-panel {
    width: 100%;
}

.register-card {
    padding: 30px 32px 24px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #263548;
    box-shadow: 0 24px 70px rgb(4 18 36 / 28%);
}

.register-card-header {
    margin-bottom: 28px;
    text-align: center;
}

.register-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    margin: 0 auto 18px;
    border-radius: 16px;
    background: #eaf0f8;
    color: #17365d;
}

.register-card-header h2 {
    color: #17365d;
    font-size: 1.75rem;
    font-weight: 800;
    line-height: 1.4;
}

.register-card-header p {
    margin-top: 8px;
    color: #5b6878;
    font-size: 0.95rem;
    line-height: 1.6;
}

/* Form fields */
.register-form {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.form-field label {
    display: block;
    margin-bottom: 9px;
    color: #263548;
    font-size: 1rem;
    font-weight: 700;
}

.form-field :deep(.v-field) {
    min-height: 52px;
    background: #ffffff;
    color: #263548;
}

.form-field :deep(.v-field__input) {
    min-height: 52px;
    font-size: 0.95rem;
}

.form-field :deep(.v-field__outline) {
    color: #bdc9d8;
}

.form-field :deep(.v-field--focused .v-field__outline) {
    color: #17365d;
}

.form-field :deep(.v-field__prepend-inner > .v-icon),
.form-field :deep(.v-field__append-inner > .v-icon) {
    color: #526781;
    opacity: 1;
}

/* Submit button */
.register-button {
    min-height: 54px;
    margin-top: 4px;
    background: #e5ac16;
    color: #17263a;
    font-size: 1rem;
    font-weight: 800;
    letter-spacing: 0;
    transition:
        background-color 180ms ease,
        box-shadow 180ms ease;
}

.register-button:hover {
    background: #d49b08;
    box-shadow: 0 5px 16px rgb(229 172 22 / 24%);
}

.register-button:focus-visible {
    outline: 3px solid #17365d;
    outline-offset: 3px;
}

/* Login link */
.login-section {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 4px;
    color: #526174;
    font-size: 0.9rem;
    text-align: center;
}

.login-link {
    color: #17365d;
    font-size: 0.9rem;
    font-weight: 800;
    text-transform: none;
}

/* Security note */
.security-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    margin-top: 24px;
    padding-top: 18px;
    border-top: 1px solid #e4eaf1;
    color: #526174;
    font-size: 0.8rem;
    line-height: 1.5;
    text-align: center;
}

.security-note :deep(.v-icon) {
    flex-shrink: 0;
    color: #217346;
}

/* Footer */
.register-footer {
    position: absolute;
    right: 20px;
    bottom: 20px;
    left: 20px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 9px;
    color: #edf3fa;
    font-size: 0.8rem;
    text-align: center;
}

.footer-separator {
    color: #ffda66;
}

/* Tablet */
@media (max-width: 960px) {
    .register-page {
        padding: 36px 28px 72px;
    }

    .register-layout {
        grid-template-columns: minmax(0, 1fr) minmax(340px, 440px);
        gap: 32px;
    }

    .brand-title {
        font-size: clamp(2.2rem, 4vw, 3rem);
    }

    .brand-description {
        font-size: 1rem;
    }

    .register-card {
        padding: 28px 24px 22px;
    }

    .register-form {
        gap: 15px;
    }
}

/* Mobile */
@media (max-width: 700px) {
    .register-page {
        padding: 28px 18px 76px;
    }

    .register-layout {
        grid-template-columns: minmax(0, 1fr);
        max-width: 480px;
        gap: 28px;
    }

    .register-introduction {
        text-align: center;
    }

    .brand-logo {
        width: 50px;
        height: 50px;
        margin: 0 auto 18px;
    }

    .brand-label {
        margin-bottom: 8px;
        font-size: 0.7rem;
        letter-spacing: 1px;
    }

    .brand-title {
        font-size: 2.25rem;
        letter-spacing: -0.8px;
    }

    .brand-description {
        margin-top: 12px;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .brand-features {
        display: none;
    }

    .register-card {
        padding: 26px 22px 22px;
    }

    .register-card-header {
        margin-bottom: 24px;
    }

    .register-card-header h2 {
        font-size: 1.55rem;
    }

    .register-form {
        gap: 16px;
    }

    .register-background-video {
        object-position: 60% center;
    }

    .register-background-overlay {
        background: rgb(23 54 93 / 82%);
    }

    .register-footer {
        bottom: 14px;
        gap: 6px;
        font-size: 0.7rem;
    }
}

/* Small phones */
@media (max-width: 380px) {
    .register-page {
        padding-right: 12px;
        padding-left: 12px;
    }

    .register-card {
        padding: 24px 16px 20px;
    }

    .brand-title {
        font-size: 2rem;
    }

    .register-footer {
        font-size: 0.65rem;
    }
}

/* Respect reduced-motion preference */
@media (prefers-reduced-motion: reduce) {
    .register-background-video {
        display: none;
    }

    .register-page {
        background: #17365d;
    }

    .register-button {
        transition: none;
    }
}
</style>
