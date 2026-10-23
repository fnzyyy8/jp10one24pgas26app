<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { useBreadcrumb } from '@/composable/useBreadcrumb';
import ChangePasswordCard from '@/pages/Auth/components/ChangePasswordCard.vue';
import ProfileSummaryCard from '@/pages/Auth/components/ProfileSummaryCard.vue';
import type { User } from '@/pages/Auth/types/profile.type';

defineProps<{
    user: User;
}>();

const { setBreadcrumbs } = useBreadcrumb();

onMounted(() => setBreadcrumbs([
    {
        title : 'Profile',
        disabled : true
    }
]))
</script>

<template>
    <Head title="My Profile" />

    <div class="profile-page">
        <!-- Background Decoration -->
        <div class="" aria-hidden="true"></div>

        <!-- Main Content -->
        <main class="profile-content">
            <div class="grid grid-cols-2 gap-3">
                <ProfileSummaryCard :user="user" />
                <ChangePasswordCard />
            </div>
        </main>
    </div>
</template>

<style scoped>
/* Page Layout */
.profile-page {
    position: relative;
    isolation: isolate;
    display: flex;
    flex-direction: column;
    width: 100%;
    min-height: 100%;
    box-sizing: border-box;
    padding: 24px;
    overflow: hidden;
    background: #f4f7fb;
    color: #263548;
}

/* Background Decoration */
.profile-decoration {
    position: absolute;
    z-index: -1;
    inset: 0;
    pointer-events: none;
    background:
        radial-gradient(circle at 95% 0%, rgb(23 54 93 / 5%), transparent 30%),
        radial-gradient(
            circle at 0% 100%,
            rgb(229 172 22 / 7%),
            transparent 28%
        );
}

/* Main Content */
.profile-content {
    position: relative;
    display: flex;
    flex: 1;
    flex-direction: column;
    width: 100%;
    max-width: 1600px;
    min-width: 0;
    margin-inline: auto;
}

/* Profile Columns */
.profile-grid {
    margin-top: 12px;
}

/* Footer */
.profile-footer {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin-top: 28px;
    padding: 18px 0 8px;
    border-top: 1px solid #dce4ee;
    color: #5b6878;
    font-size: 0.8rem;
    line-height: 1.5;
    text-align: center;
}

.footer-separator {
    color: #b8870d;
    font-weight: 700;
}

/* Tablet */
@media (max-width: 960px) {
    .profile-page {
        padding: 20px;
    }

    .profile-grid {
        margin-top: 8px;
    }
}

/* Mobile */
@media (max-width: 600px) {
    .profile-page {
        padding: 16px 12px;
    }

    .profile-grid {
        margin-top: 4px;
    }

    .profile-footer {
        gap: 6px;
        margin-top: 20px;
        padding-top: 16px;
        font-size: 0.72rem;
    }
}
</style>
