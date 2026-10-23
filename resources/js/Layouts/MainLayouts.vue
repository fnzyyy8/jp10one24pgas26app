<script setup lang="ts">
import AppBreadcrumb from '@/components/AppBreadcrumb.vue';
import AppToast from '@/components/AppToast.vue';
import HeadMenu from '@/Layouts/HeadMenu.vue';
import SideMenu from '@/Layouts/SideMenu.vue';
</script>

<template>
    <div class="app-layout">
        <!-- Application header -->
        <header class="app-header">
            <HeadMenu />
        </header>

        <!-- Main application body -->
        <div class="app-body">
            <!-- Sidebar navigation -->
            <aside class="app-sidebar">
                <SideMenu />
            </aside>

            <!-- Main content column -->
            <div class="app-main">
                <!-- Breadcrumb navigation -->
                <div class="app-breadcrumb">
                    <AppBreadcrumb />
                </div>

                <!-- Scrollable page content -->
                <main class="app-content">
                    <slot />
                </main>
            </div>
        </div>

        <!-- Global notifications -->
        <AppToast />
    </div>
</template>

<style scoped>
/* Application layout */
.app-layout {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: 100vh;
    height: 100dvh;
    overflow: hidden;
    background: #f4f7fb;
    color: #263548;
}

/* Header */
.app-header {
    position: relative;
    z-index: 100;
    flex: 0 0 64px;
    width: 100%;
    min-width: 0;
    background: #17365d;
}

/* Body below the header */
.app-body {
    display: flex;
    flex: 1 1 auto;
    min-width: 0;
    min-height: 0;
    overflow: hidden;
}

/* Sidebar */
.app-sidebar {
    flex: 0 0 260px;
    width: 260px;
    min-width: 0;
    height: 100%;
    overflow-x: hidden;
    overflow-y: auto;
    overscroll-behavior: contain;
    border-right: 1px solid #dce4ee;
    background: #17365d;
    scrollbar-width: thin;
    scrollbar-color: #647f9f #17365d;
}

/* Main content column */
.app-main {
    display: flex;
    flex: 1 1 auto;
    flex-direction: column;
    min-width: 0;
    min-height: 0;
    overflow: hidden;
    background: #f4f7fb;
}

/* Breadcrumb bar */
.app-breadcrumb {
    display: flex;
    flex: 0 0 56px;
    align-items: center;
    min-width: 0;
    padding: 0 24px;
    overflow-x: auto;
    overflow-y: hidden;
    border-bottom: 1px solid #dce4ee;
    background: #ffffff;
    color: #263548;
    scrollbar-width: thin;
}

/* Main scrollable area */
.app-content {
    flex: 1 1 auto;
    min-width: 0;
    min-height: 0;
    padding: 24px;
    overflow-x: auto;
    overflow-y: auto;
    overscroll-behavior: contain;
    background: #f4f7fb;
    color: #263548;
    scrollbar-width: thin;
    scrollbar-color: #b7c5d6 #f4f7fb;
}

/* Tablet */
@media (max-width: 960px) {
    .app-sidebar {
        flex-basis: 230px;
        width: 230px;
    }

    .app-breadcrumb {
        flex-basis: 52px;
        padding-inline: 20px;
    }

    .app-content {
        padding: 20px;
    }
}

/* Mobile */
@media (max-width: 600px) {
    .app-header {
        flex-basis: 60px;
    }

    .app-body {
        position: relative;
    }

    .app-sidebar {
        flex: 0 0 200px;
        width: 200px;
    }

    .app-breadcrumb {
        flex-basis: 48px;
        padding-inline: 12px;
    }

    .app-content {
        padding: 16px 12px;
    }
}

/* Small mobile */
@media (max-width: 380px) {
    .app-sidebar {
        flex-basis: 180px;
        width: 180px;
    }

    .app-content {
        padding: 12px 10px;
    }
}
</style>
