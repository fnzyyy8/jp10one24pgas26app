<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { computed } from 'vue';
import { route } from 'ziggy-js';

const props = defineProps({
    status: Number,
});

const title = computed(() => {
    return (
        {
            503: '503',
            500: '500',
            404: '404',
            403: '403',
        }[props.status ?? 0] || 'Terjadi Masalah yang tidak di ketahui'
    );
});

const description = computed(() => {
    return (
        {
            503: 'Kami sedang melakukan Pemeliharaan',
            500: 'Maaf, terjadi kesalahan pada server',
            404: 'Maaf, Halaman tidak ditemukan',
            403: 'Maaf anda tidak memiliki akses ke halaman ini',
        }[props.status ?? 0] || 'Terjadi masalah yang tidak diketahui'
    );
});

const directToDashboard = () => {
    router.visit(route('home'));
};
</script>

<template>
    <div class="error-page">
        <div class="error-content">
            <div class="error-card">
                <div class="card-accent"></div>

                <div class="card-body">
                    <div class="error-icon">
                        <v-icon
                            icon="mdi-file-question-outline"
                            size="56"
                            color="primary"
                        />
                    </div>

                    <div class="error-code">ERROR {{ status }}</div>

                    <h1 class="error-title">
                        {{ title }}
                    </h1>

                    <p class="error-description">
                        {{ description }}
                    </p>

                    <div class="error-actions">
                        <v-btn
                            color="primary"
                            prepend-icon="mdi-view-dashboard-outline"
                            size="large"
                            @click="directToDashboard"
                        >
                            Dashboard
                        </v-btn>
                    </div>

                    <div class="error-footer">
                        <div class="footer-brand">
                            <span class="footer-dot"></span>

                            <div>
                                <div class="footer-title">Dashboard Jargas</div>
                                <div class="footer-description">
                                    Gas Pipeline Monitoring System
                                </div>
                            </div>
                        </div>

                        <span class="footer-status"> HTTP {{ status }} </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.error-page {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 32px 20px;
    background: #f3f6fb;
}

.error-content {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.error-card {
    width: 100%;
    max-width: 500px;
    overflow: hidden;
    background: #ffffff;
    border: 1px solid #dce4ee;
    border-radius: 16px;
    box-shadow: 0 10px 35px rgb(25 56 93 / 6%);
}

.card-accent {
    height: 5px;
    background: linear-gradient(
        90deg,
        #19385d 0%,
        #19385d 78%,
        #e5ac16 78%,
        #e5ac16 100%
    );
}

.card-body {
    padding: 36px 34px 24px;
    text-align: center;
}

.error-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #edf3fb;
    border: 1px solid #e2ebf7;
    border-radius: 50%;
}

.error-code {
    color: #1768bf;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 2px;
}

.error-title {
    margin-top: 16px;
    color: #19385d;
    font-size: 30px;
    font-weight: 700;
    line-height: 1.3;
}

.error-description {
    max-width: 360px;
    margin: 12px auto 0;
    color: #64748b;
    font-size: 14px;
    line-height: 1.8;
}

.error-actions {
    margin-top: 28px;
    display: flex;
    justify-content: center;
}

.error-actions :deep(.v-btn) {
    min-height: 44px;
    padding: 0 24px;
    border-radius: 8px;
    font-weight: 600;
    letter-spacing: 0;
    box-shadow: none;
}

.error-footer {
    margin-top: 28px;
    padding-top: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    border-top: 1px solid #e5eaf1;
}

.footer-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    text-align: left;
}

.footer-dot {
    width: 7px;
    height: 7px;
    flex-shrink: 0;
    border-radius: 50%;
    background: #e5ac16;
}

.footer-title {
    color: #19385d;
    font-size: 11px;
    font-weight: 700;
}

.footer-description {
    margin-top: 3px;
    color: #64748b;
    font-size: 10px;
}

.footer-status {
    color: #64748b;
    font-size: 11px;
    white-space: nowrap;
}

@media (max-width: 600px) {
    .error-page {
        padding: 20px 14px;
    }

    .card-body {
        padding: 28px 20px 20px;
    }

    .error-icon {
        width: 84px;
        height: 84px;
    }

    .error-title {
        font-size: 26px;
    }

    .error-footer {
        flex-wrap: wrap;
    }
}
</style>
