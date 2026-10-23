<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { PageProps } from '@/types';
import { route } from 'ziggy-js';

const page = usePage<PageProps>();

const user = computed(() => (page.props.auth as any)?.user);

const userName = computed(() => user.value?.name ?? 'User');

const userPosition = computed(
    () => user.value?.position ?? user.value?.division ?? 'Dashboard User',
);

const userInitials = computed(() => {
    const name = userName.value.trim();

    if (!name) {
        return 'U';
    }

    return name
        .split(/\s+/)
        .slice(0, 2)
        .map((part: string) => part.charAt(0))
        .join('')
        .toUpperCase();
});

const openSignature = () => {
    router.visit(route('signatures.index'));
};
const openProfile = () => {
    router.visit(route('profile.show'));
};

const logout = () => {
    router.post(route('logout'));
};

</script>

<template>
    <v-menu
        width="260"
        :offset="8"
        location="bottom end"
        transition="fade-transition"
    >
        <template #activator="{ props, isActive }">
            <button
                v-bind="props"
                type="button"
                class="user-menu-trigger"
                aria-label="Open user menu"
                :aria-expanded="isActive"
            >
                <div class="user-avatar">
                    {{ userInitials }}
                </div>

                <div class="user-information">
                    <span class="user-name">
                        {{ userName }}
                    </span>

                    <span class="user-position">
                        {{ userPosition }}
                    </span>
                </div>

                <v-icon
                    :icon="isActive ? 'mdi-chevron-up' : 'mdi-chevron-down'"
                    size="20"
                    class="menu-chevron"
                />
            </button>
        </template>

        <v-list class="user-dropdown" bg-color="#FFFFFF" density="comfortable">
            <v-list-item
                prepend-icon="mdi-bell"
                title="Notifikasi"
                rounded="lg"
                class="dropdown-item"
            />
            <v-list-item
                prepend-icon="mdi-account-circle-outline"
                title="Profil Saya"
                rounded="lg"
                class="dropdown-item"
                @click="openProfile"
            />
            <v-list-item
                prepend-icon="mdi-key"
                title="Signature"
                rounded="lg"
                class="dropdown-item"
                @click="openSignature"
            />
            <v-list-item
                prepend-icon="mdi-logout"
                title="Keluar dari Aplikasi"
                rounded="lg"
                class="dropdown-item logout-item"
                @click="logout"
            />
        </v-list>
    </v-menu>
</template>

<style scoped>
/* User menu trigger */
.user-menu-trigger {
    display: flex;
    align-items: center;
    gap: 11px;
    min-width: 0;
    max-width: 320px;
    padding: 7px 10px;
    border: 1px solid rgb(255 255 255 / 25%);
    border-radius: 10px;
    background: rgb(255 255 255 / 8%);
    color: #ffffff;
    text-align: left;
    cursor: pointer;
    transition:
        background-color 0.2s ease,
        border-color 0.2s ease;
}

.user-menu-trigger:hover {
    border-color: rgb(255 255 255 / 45%);
    background: rgb(255 255 255 / 14%);
}

.user-menu-trigger:focus-visible {
    outline: 3px solid #ffda66;
    outline-offset: 3px;
}

/* Avatar */
.user-avatar,
.dropdown-avatar {
    display: flex;
    flex-shrink: 0;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border: 1px solid rgb(255 255 255 / 35%);
    border-radius: 10px;
    background: #ffffff;
    color: #17365d;
    font-size: 0.85rem;
    font-weight: 800;
}

/* User information */
.user-information {
    display: flex;
    flex-direction: column;
    gap: 5px;
    min-width: 0;
    text-align: left;
}

.user-name {
    max-width: 180px;
    overflow: hidden;
    color: #ffffff;
    font-size: 0.85rem;
    font-weight: 700;
    line-height: 1.3;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.user-position {
    max-width: 180px;
    overflow: hidden;
    color: #dce6f1;
    font-size: 0.75rem;
    line-height: 1.3;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.menu-chevron {
    flex-shrink: 0;
    margin-left: 2px;
    color: #dce6f1;
}

/* Dropdown */
.user-dropdown {
    padding: 8px;
    border: 1px solid #dce4ee;
    border-radius: 12px;
    background: #ffffff;
    color: #263548;
    box-shadow: 0 12px 32px rgb(23 54 93 / 16%);
}

.dropdown-header {
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding: 12px;
}

.dropdown-label {
    color: #526781;
    font-size: 0.7rem;
    font-weight: 800;
    letter-spacing: 0.08em;
}

.dropdown-user-information {
    display: flex;
    align-items: center;
    gap: 11px;
    min-width: 0;
}

.dropdown-avatar {
    width: 42px;
    height: 42px;
    border-color: #dce6f1;
    background: #eaf0f8;
}

.dropdown-user-details {
    display: flex;
    flex: 1;
    flex-direction: column;
    gap: 5px;
    min-width: 0;
}

.dropdown-user-name {
    overflow-wrap: anywhere;
    color: #17365d;
    font-size: 0.9rem;
    font-weight: 700;
    line-height: 1.4;
}

.dropdown-user-position {
    overflow-wrap: anywhere;
    color: #5b6878;
    font-size: 0.8rem;
    line-height: 1.4;
}

.dropdown-divider {
    margin: 4px 0 8px;
    border-color: #e4eaf1;
}

/* Dropdown actions */
.dropdown-item {
    min-height: 48px;
    margin-bottom: 4px;
    color: #263548;
    font-size: 0.9rem;
    font-weight: 500;
}

.dropdown-item :deep(.v-icon) {
    color: #526781;
    opacity: 1;
}

.dropdown-item:hover {
    background: #eaf0f8;
    color: #17365d;
}

.dropdown-item:hover :deep(.v-icon) {
    color: #17365d;
}

.logout-item:hover {
    background: #fef2f2;
    color: #b42318;
}

.logout-item:hover :deep(.v-icon) {
    color: #b42318;
}

/* Mobile */
@media (max-width: 600px) {
    .user-menu-trigger {
        gap: 7px;
        padding: 5px;
        border-color: transparent;
        background: transparent;
    }

    .user-menu-trigger:hover {
        border-color: rgb(255 255 255 / 20%);
        background: rgb(255 255 255 / 10%);
    }

    .user-avatar {
        width: 34px;
        height: 34px;
        border-radius: 9px;
    }

    .user-information {
        max-width: 115px;
    }

    .user-name,
    .user-position {
        max-width: 115px;
    }
}

@media (max-width: 380px) {
    .user-information {
        display: none;
    }
}
</style>
