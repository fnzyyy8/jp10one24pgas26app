```vue
<script setup lang="ts">
import UserMenu from '@/Layouts/UserMenu.vue';
</script>

<template>
    <header class="app-header">
        <div class="header-brand">
            <img
                src="/images/pgas_white.png"
                alt="PGN Logo"
                class="header-logo"
            />

            <div class="brand-divider"></div>

            <div class="brand-information">
                <span class="brand-title">One Jargas</span>

                <span class="brand-subtitle">
                    Sistem pemantauan terintegrasi
                </span>
            </div>
        </div>

        <UserMenu />
    </header>
</template>

<style scoped>
.app-header {
    position: relative;
    z-index: 100;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    min-height: 64px;
    padding: 0 24px;
    border-bottom: 1px solid rgb(255 255 255 / 15%);
    background: #17365d;
    color: #ffffff;
}

.header-brand {
    display: flex;
    align-items: center;
    gap: 16px;
    min-width: 0;
}

.header-logo {
    display: block;
    flex-shrink: 0;
    width: 120px;
    height: 34px;
    object-fit: contain;
    object-position: left center;
}

.brand-divider {
    width: 1px;
    height: 32px;
    flex-shrink: 0;
    background: rgb(255 255 255 / 25%);
}

.brand-information {
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-width: 0;
}

.brand-title {
    color: #ffffff;
    font-size: 0.95rem;
    font-weight: 700;
    line-height: 1.3;
}

.brand-subtitle {
    color: #dce6f1;
    font-size: 0.75rem;
    line-height: 1.3;
}

/* Tablet */
@media (max-width: 960px) {
    .app-header {
        padding-inline: 18px;
    }

    .header-brand {
        gap: 12px;
    }

    .header-logo {
        width: 105px;
    }
}

/* Mobile */
@media (max-width: 600px) {
    .app-header {
        min-height: 60px;
        padding-inline: 12px;
    }

    .header-brand {
        gap: 9px;
    }

    .header-logo {
        width: 82px;
        height: 28px;
    }

    .brand-divider {
        height: 26px;
    }

    .brand-title {
        font-size: 0.78rem;
    }

    .brand-subtitle {
        display: none;
    }
}

/* Small mobile screens */
@media (max-width: 380px) {
    .header-brand {
        gap: 7px;
    }

    .header-logo {
        width: 68px;
    }

    .brand-title {
        font-size: 0.72rem;
    }
}
</style>
```
