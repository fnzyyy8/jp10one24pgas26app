<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import type { UserRole, User } from '@/pages/UserManagement/type/index.type';

type MenuItem = {
    title: string;
    icon?: string;
    href?: string;
    children?: MenuItem[];
    roles?: UserRole[];
};
type SharedProps = {
    auth: {
        user: User | null;
    };
};

const page = usePage<SharedProps>();
const open = ref<string[]>([]);

const items: MenuItem[] = [
    {
        title: 'Dashboard',
        icon: 'mdi-view-dashboard-outline',
        href: '/',
    },
    {
        title: 'Man Power',
        icon: 'mdi-account-hard-hat-outline',
        children: [
            { title: 'Work Scope', href: '/man-power/work-scope' },
            { title: 'Worker', href: '/man-power/worker' },
        ],
    },
    {
        title: 'Project',
        icon: 'mdi-office-building-outline',
        children: [
            { title: 'SPK Awal', href: '/projects' },
            { title: 'Documents (Beta)', href: '/documents' },
        ],
    },
    {
        title: 'Project Control',
        icon: 'mdi-hard-hat',
        children: [{ title: 'BOQ', href: '/project-control/boq' }],
    },
    {
        title: 'Engineering',
        icon: 'mdi-hammer-wrench',
        children: [
            { title: 'Item Pekerjaan', href: '/engineering/item-details' },
            { title: 'Harga Satuan', href: '/engineering' },
        ],
    },
    {
        title: 'User Management',
        icon: 'mdi-account-supervisor',
        href: '/user-management',
        roles: ['super_admin', 'admin'],
    },
];

const currentUrl = computed(() => page.url.split('?')[0]);

const isActive = (href?: string): boolean => {
    if (!href) {
        return false;
    }

    if (href === '/') {
        return currentUrl.value === '/';
    }

    return currentUrl.value === href || currentUrl.value.startsWith(`${href}/`);
};

const isGroupActive = (item: MenuItem): boolean => {
    return item.children?.some((child) => isActive(child.href)) ?? false;
};

const navigate = (href?: string): void => {
    if (!href) {
        return;
    }

    router.visit(href);
};

const visibleItems = computed(() => {
    const role = page.props.auth.user?.role;

    return items.filter((item) => {
        if (!item.roles) {
            return true;
        }

        if (!role) {
            return false;
        }

        return item.roles.includes(role);
    });
});
</script>

<template>
    <aside class="side-menu">
        <div class="sidebar-heading">
            <span class="sidebar-eyebrow">NAVIGASI UTAMA</span>
            <span class="sidebar-caption">Menu Aplikasi</span>
        </div>

        <v-list v-model:opened="open" class="navigation-list" nav>
            <template v-for="item in visibleItems" :key="item.title">
                <v-list-group
                    v-if="item.children"
                    :value="item.title"
                    class="navigation-group"
                    :class="{ 'group-active': isGroupActive(item) }"
                >
                    <template #activator="{ props }">
                        <v-list-item
                            v-bind="props"
                            :title="item.title"
                            :prepend-icon="item.icon"
                            class="navigation-item group-activator"
                            :active="isGroupActive(item)"
                            rounded="lg"
                        />
                    </template>

                    <v-list-item
                        v-for="child in item.children"
                        :key="child.title"
                        :title="child.title"
                        :value="child.title"
                        class="navigation-child"
                        :active="isActive(child.href)"
                        rounded="lg"
                        @click="navigate(child.href)"
                    />
                </v-list-group>

                <v-list-item
                    v-else
                    :title="item.title"
                    :prepend-icon="item.icon"
                    :active="isActive(item.href)"
                    class="navigation-item"
                    rounded="lg"
                    @click="navigate(item.href)"
                />
            </template>
        </v-list>

        <div class="sidebar-footer">
            <div class="footer-indicator"></div>

            <div class="footer-information">
                <span class="footer-title">Dashboard Jargas</span>
                <span class="footer-subtitle">
                    Gas Pipeline Monitoring System
                </span>
            </div>
        </div>
    </aside>
</template>

<style scoped>
/* Sidebar */
.side-menu {
    display: flex;
    flex-direction: column;
    width: 100%;
    min-height: 100%;
    background: #17365d;
    color: #ffffff;
}

/* Sidebar heading */
.sidebar-heading {
    display: flex;
    flex-direction: column;
    gap: 6px;
    padding: 24px 22px 16px;
}

.sidebar-eyebrow {
    color: #ffda66;
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 0.08em;
}

.sidebar-caption {
    color: #dce6f1;
    font-size: 0.85rem;
}

/* Navigation list */
.navigation-list {
    flex: 1;
    padding: 8px 12px 16px;
    background: transparent;
    color: #e2eaf3;
}

/* Main navigation item */
.navigation-item {
    min-height: 50px;
    margin-bottom: 6px;
    border-radius: 8px;
    color: #e2eaf3;
    font-size: 0.9rem;
    font-weight: 500;
}

.navigation-item :deep(.v-list-item-title) {
    color: inherit;
    font-size: 0.9rem;
    font-weight: 500;
}

.navigation-item :deep(.v-list-item__prepend > .v-icon) {
    color: #c4d3e5;
    opacity: 1;
}

/* Main navigation hover */
.navigation-item:hover,
.navigation-child:hover {
    background: rgb(255 255 255 / 10%);
    color: #ffffff;
}

.navigation-item:hover :deep(.v-list-item__prepend > .v-icon) {
    color: #ffda66;
}

/* Active standalone menu */
.navigation-item.v-list-item--active {
    background: #e5ac16 !important;
    color: #17365d !important;
    font-weight: 700;
}

.navigation-item.v-list-item--active :deep(.v-list-item-title) {
    color: #17365d !important;
    font-weight: 700;
}

.navigation-item.v-list-item--active :deep(.v-list-item__prepend > .v-icon),
.navigation-item.v-list-item--active :deep(.v-list-item__append > .v-icon) {
    color: #17365d !important;
    opacity: 1;
}

/* Navigation groups */
.navigation-group {
    margin-bottom: 6px;
}

/* Group arrow */
.group-activator :deep(.v-list-item__append > .v-icon) {
    color: #dce6f1;
    opacity: 1;
}

/* Active group heading */
.group-active > .group-activator,
.group-active > .group-activator.v-list-item--active {
    background: #e5ac16 !important;
    color: #17365d !important;
}

.group-active > .group-activator :deep(.v-list-item-title) {
    color: #17365d !important;
    font-weight: 700;
}

.group-active > .group-activator :deep(.v-list-item__prepend > .v-icon),
.group-active > .group-activator :deep(.v-list-item__append > .v-icon) {
    color: #17365d !important;
    opacity: 1;
}

/* Keep the gold background and dark text when hovering */
.group-active > .group-activator:hover,
.navigation-item.v-list-item--active:hover {
    background: #e5ac16 !important;
    color: #17365d !important;
}

/* Submenu */
.navigation-child {
    min-height: 44px;
    margin: 4px 0 4px 14px;
    padding-inline-start: 20px !important;
    border-radius: 8px;
    color: #dce6f1;
    font-size: 0.85rem;
}

.navigation-child :deep(.v-list-item-title) {
    color: inherit;
    font-size: 0.85rem;
}

.navigation-child :deep(.v-list-item__spacer) {
    width: 0;
}

/* Active submenu */
.navigation-child.v-list-item--active {
    background: rgb(255 218 102 / 15%) !important;
    color: #ffda66 !important;
    font-weight: 700;
}

.navigation-child.v-list-item--active :deep(.v-list-item-title) {
    color: #ffda66 !important;
    font-weight: 700;
}

/* Active submenu indicator */
.navigation-child.v-list-item--active::before {
    position: absolute;
    left: 8px;
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: #ffda66;
    content: '';
}

/* Sidebar footer */
.sidebar-footer {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: auto;
    padding: 18px 20px;
    border-top: 1px solid rgb(255 255 255 / 15%);
}

.footer-indicator {
    width: 9px;
    height: 9px;
    flex-shrink: 0;
    border-radius: 50%;
    background: #ffda66;
}

.footer-information {
    display: flex;
    flex-direction: column;
    gap: 5px;
    min-width: 0;
}

.footer-title {
    color: #ffffff;
    font-size: 0.8rem;
    font-weight: 700;
}

.footer-subtitle {
    color: #dce6f1;
    font-size: 0.7rem;
    line-height: 1.4;
}

/* Responsive layout */
@media (max-width: 600px) {
    .sidebar-heading {
        padding: 20px 16px 14px;
    }

    .navigation-list {
        padding-inline: 8px;
    }

    .sidebar-footer {
        padding: 16px;
    }
}
</style>
