<script setup lang="ts">
import { router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { route } from 'ziggy-js';

const showPassword = ref(false);

const form = useForm({
    email: '',
    password: '',
});

const submitLogin = () => {
    form.post(route('login.authenticate'), {
        preserveScroll: true,
    });
};

const toRegister = () => {
    router.visit(route('register'));
};
</script>

<template>
    <GuestLayout>
        <main class="login-page">
            <!-- Pipeline background video -->
            <video
                class="login-background-video"
                autoplay
                muted
                loop
                playsinline
                preload="metadata"
                aria-hidden="true"
            >
                <source src="/videos/pipeline_video.mp4" type="video/mp4" />
            </video>

            <!-- Corporate Blue overlay -->
            <div class="login-background-overlay"></div>

            <div class="login-layout">
                <!-- Brand information -->
                <section class="login-introduction">
                    <h1 class="brand-title">
                        One
                        <span>Jargas</span>
                    </h1>

                    <p class="brand-description">
                        Sistem pemantauan dan pengelolaan proyek jaringan gas
                        dalam satu platform terintegrasi.
                    </p>
                </section>

                <!-- Login form -->
                <section class="login-panel">
                    <v-card class="login-card" elevation="0" rounded="xl">
                        <div class="login-card-header">
                            <h2>Login</h2>
                        </div>

                        <v-form
                            class="login-form"
                            @submit.prevent="submitLogin"
                        >
                            <div class="form-field">
                                <label for="login-email">Alamat Email</label>

                                <v-text-field
                                    id="login-email"
                                    v-model="form.email"
                                    placeholder="Contoh: nama@perusahaan.co.id"
                                    prepend-inner-icon="mdi-email-outline"
                                    type="email"
                                    variant="outlined"
                                    density="comfortable"
                                    rounded="lg"
                                    autocomplete="username"
                                    :error-messages="form.errors.email"
                                    :disabled="form.processing"
                                    hide-details="auto"
                                />
                            </div>

                            <div class="form-field">
                                <label for="login-password">Kata Sandi</label>

                                <v-text-field
                                    id="login-password"
                                    v-model="form.password"
                                    placeholder="Masukkan kata sandi"
                                    prepend-inner-icon="mdi-lock-outline"
                                    :type="showPassword ? 'text' : 'password'"
                                    :append-inner-icon="
                                        showPassword
                                            ? 'mdi-eye-off-outline'
                                            : 'mdi-eye-outline'
                                    "
                                    variant="outlined"
                                    density="comfortable"
                                    rounded="lg"
                                    autocomplete="current-password"
                                    :error-messages="form.errors.password"
                                    :disabled="form.processing"
                                    hide-details="auto"
                                    @click:append-inner="
                                        showPassword = !showPassword
                                    "
                                />
                            </div>

                            <v-btn
                                class="login-button"
                                type="submit"
                                block
                                size="large"
                                rounded="lg"
                                :loading="form.processing"
                                :disabled="form.processing"
                            >
                                <span>Login</span>
                            </v-btn>

                            <div class="flex flex-col items-center">
                                <span>Belum memiliki akun?</span>

                                <v-btn
                                    class="register-button"
                                    variant="text"
                                    size="default"
                                    :disabled="form.processing"
                                    @click="toRegister"
                                >
                                    Daftar di sini
                                </v-btn>
                            </div>
                        </v-form>

                    </v-card>
                </section>
            </div>

            <footer class="login-footer">
                <span>Dashboard Jargas</span>
                <span class="footer-separator">•</span>
                <span>Gas Pipeline Monitoring System</span>
            </footer>
        </main>
    </GuestLayout>
</template>

<style scoped>
.login-page {
    position: relative;
    isolation: isolate;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    min-height: 100vh;
    min-height: 100dvh;
    overflow: hidden;
    padding: 56px 6vw 72px;
    background: #17365d;
    color: #263548;
}

/* Background video */
.login-background-video {
    position: absolute;
    z-index: -2;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transform: scaleX(-1);
}

/* Maintain contrast while keeping the pipeline visible */
.login-background-overlay {
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

.login-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(380px, 460px);
    align-items: center;
    gap: clamp(40px, 7vw, 110px);
    width: 100%;
    max-width: 1240px;
    margin: auto;
}

/* Brand introduction */
.login-introduction {
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

/* Login card */
.login-panel {
    width: 100%;
}

.login-card {
    padding: 36px 32px 24px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #263548;
    box-shadow: 0 24px 70px rgb(4 18 36 / 28%);
}

.login-card-header {
    margin-bottom: 30px;
    text-align: center;
}

.login-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    margin: 0 auto 20px;
    border-radius: 16px;
    background: #eaf0f8;
    color: #17365d;
}

.login-card-header h2 {
    color: #17365d;
    font-size: 1.75rem;
    font-weight: 800;
    line-height: 1.4;
}

.login-card-header p {
    margin-top: 8px;
    color: #5b6878;
    font-size: 0.95rem;
    line-height: 1.6;
}

/* Form fields */
.login-form {
    display: flex;
    flex-direction: column;
    gap: 22px;
}

.form-field label {
    display: block;
    margin-bottom: 9px;
    color: #263548;
    font-size: 1rem;
    font-weight: 700;
}

.form-field :deep(.v-field) {
    min-height: 54px;
    background: #ffffff;
    color: #263548;
}

.form-field :deep(.v-field__input) {
    min-height: 54px;
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
.login-button {
    min-height: 54px;
    margin-top: 2px;
    background: #e5ac16;
    color: #17263a;
    font-size: 1rem;
    font-weight: 800;
    letter-spacing: 0;
    transition:
        background-color 180ms ease,
        box-shadow 180ms ease;
}

.login-button:hover {
    background: #d49b08;
    box-shadow: 0 5px 16px rgb(229 172 22 / 24%);
}

.login-button:focus-visible {
    outline: 3px solid #17365d;
    outline-offset: 3px;
}

/* Registration */


.register-button {
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
    margin-top: 26px;
    padding-top: 20px;
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
.login-footer {
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
    .login-page {
        padding: 40px 28px 72px;
    }

    .login-layout {
        grid-template-columns: minmax(0, 1fr) minmax(340px, 420px);
        gap: 32px;
    }

    .brand-title {
        font-size: clamp(2.2rem, 4vw, 3rem);
    }

    .brand-description {
        font-size: 1rem;
    }

    .login-card {
        padding: 30px 24px 22px;
    }
}

/* Mobile */
@media (max-width: 700px) {
    .login-page {
        align-items: center;
        padding: 28px 18px 76px;
    }

    .login-layout {
        grid-template-columns: minmax(0, 1fr);
        max-width: 460px;
        gap: 28px;
    }

    .login-introduction {
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

    .login-card {
        padding: 28px 22px 22px;
    }

    .login-card-header {
        margin-bottom: 26px;
    }

    .login-card-header h2 {
        font-size: 1.55rem;
    }

    .login-background-video {
        object-position: 60% center;
    }

    .login-background-overlay {
        background: rgb(23 54 93 / 82%);
    }

    .login-footer {
        bottom: 14px;
        gap: 6px;
        font-size: 0.7rem;
    }
}

/* Small phones */
@media (max-width: 380px) {
    .login-page {
        padding-right: 12px;
        padding-left: 12px;
    }

    .login-card {
        padding: 24px 16px 20px;
    }

    .brand-title {
        font-size: 2rem;
    }

    .login-footer {
        font-size: 0.65rem;
    }
}

/* Respect reduced-motion preference */
@media (prefers-reduced-motion: reduce) {
    .login-background-video {
        display: none;
    }

    .login-page {
        background: #17365d;
    }

    .login-button {
        transition: none;
    }
}
</style>
