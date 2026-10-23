<script setup lang="ts">
import { computed } from 'vue';
import type { User } from '@/pages/Auth/types/profile.type';

const props = defineProps<{
    user: User;
}>();

const userInitials = computed(() => {
    return (props.user.name ?? '')
        .trim()
        .split(/\s+/)
        .filter(Boolean)
        .slice(0, 2)
        .map((word) => word.charAt(0).toUpperCase())
        .join('');
});
</script>

<template>
    <v-card class="profile-card summary-card" rounded="xl" elevation="0">
        <!-- Profile Banner -->
        <div class="summary-banner">
            <div class="banner-decoration" aria-hidden="true"></div>

            <div class="profile-avatar">
                {{ userInitials || 'U' }}
            </div>

            <h2>{{ user.name || 'User' }}</h2>

            <p class="user-position">
                {{ user.position?.toUpperCase() || 'Position not set' }}
            </p>

            <v-chip class="account-chip" size="small" variant="tonal">
                <v-icon icon="mdi-check-circle" size="16" class="mr-1" />
                Account Active
            </v-chip>
        </div>

        <v-divider class="card-divider" />

        <!-- User Details -->
        <div class="summary-details">
            <div class="detail-item">
                <div class="detail-icon">
                    <v-icon icon="mdi-email-outline" />
                </div>

                <div class="detail-content">
                    <span class="detail-label">Email Address</span>
                    <span class="detail-value">
                        {{ user.email || 'Not provided' }}
                    </span>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-icon">
                    <v-icon icon="mdi-domain" />
                </div>

                <div class="detail-content">
                    <span class="detail-label">Division</span>
                    <span class="detail-value">
                        {{ user.division?.toUpperCase() || 'Not assigned' }}
                    </span>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-icon">
                    <v-icon icon="mdi-briefcase-outline" />
                </div>

                <div class="detail-content">
                    <span class="detail-label">Position</span>
                    <span class="detail-value">
                        {{ user.position?.toUpperCase() || 'Not assigned' }}
                    </span>
                </div>
            </div>
        </div>
    </v-card>
</template>

<style scoped>
/* Main Card */
.profile-card {
    width: 100%;
    overflow: hidden;
    border: 1px solid #dce4ee;
    background: #ffffff;
    color: #263548;
    box-shadow: 0 4px 16px rgb(23 54 93 / 6%);
}

/* Profile Banner */
.summary-banner {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 30px 20px 26px;
    overflow: hidden;
    background: linear-gradient(145deg, #17365d, #234a76);
    text-align: center;
}

/* Decorative Circles */
.banner-decoration {
    position: absolute;
    top: -65px;
    right: -55px;
    width: 170px;
    height: 170px;
    border: 1px solid rgb(255 255 255 / 15%);
    border-radius: 50%;
    box-shadow:
        0 0 0 22px rgb(255 255 255 / 5%),
        0 0 0 44px rgb(255 255 255 / 3%);
    pointer-events: none;
}

/* User Avatar */
.profile-avatar {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 82px;
    height: 82px;
    flex-shrink: 0;
    margin-bottom: 18px;
    border: 3px solid #ffffff;
    border-radius: 50%;
    background: #ffda66;
    color: #17365d;
    font-size: 1.8rem;
    font-weight: 800;
    box-shadow: 0 4px 12px rgb(0 0 0 / 12%);
}

/* User Name */
.summary-banner h2 {
    position: relative;
    max-width: 100%;
    overflow-wrap: anywhere;
    color: #ffffff;
    font-size: 1.2rem;
    font-weight: 700;
    line-height: 1.5;
}

/* User Position */
.user-position {
    position: relative;
    margin-top: 6px;
    overflow-wrap: anywhere;
    color: #e2eaf3;
    font-size: 0.88rem;
    line-height: 1.5;
}

/* Account Status */
.account-chip {
    margin-top: 14px;
    border: 1px solid rgb(255 255 255 / 20%);
    background: #e7f5ec !important;
    color: #217346 !important;
    font-weight: 600;
}

/* Divider */
.card-divider {
    border-color: #e4eaf1;
    opacity: 1;
}

/* User Details */
.summary-details {
    display: grid;
    gap: 22px;
    padding: 24px;
}

/* Detail Row */
.detail-item {
    display: flex;
    align-items: flex-start;
    gap: 13px;
    min-width: 0;
}

/* Detail Icon */
.detail-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    border: 1px solid #dce6f1;
    border-radius: 10px;
    background: #eaf0f8;
    color: #17365d;
}

/* Detail Text Container */
.detail-content {
    display: flex;
    flex: 1;
    flex-direction: column;
    gap: 5px;
    min-width: 0;
}

/* Detail Label */
.detail-label {
    color: #5b6878;
    font-size: 0.8rem;
    font-weight: 500;
    line-height: 1.4;
}

/* Detail Value */
.detail-value {
    overflow-wrap: anywhere;
    color: #263548;
    font-size: 0.9rem;
    font-weight: 600;
    line-height: 1.5;
}

/* Tablet */
@media (max-width: 960px) {
    .summary-details {
        gap: 20px;
        padding: 22px;
    }
}

/* Mobile */
@media (max-width: 600px) {
    .summary-banner {
        padding: 26px 16px 22px;
    }

    .profile-avatar {
        width: 72px;
        height: 72px;
        font-size: 1.6rem;
    }

    .summary-banner h2 {
        font-size: 1.1rem;
    }

    .summary-details {
        gap: 18px;
        padding: 20px 16px;
    }

    .detail-value {
        font-size: 0.85rem;
    }
}
</style>
