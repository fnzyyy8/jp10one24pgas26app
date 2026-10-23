import { createInertiaApp } from '@inertiajs/vue3';
import { AllCommunityModule, ModuleRegistry } from 'ag-grid-community';
import { createPinia } from 'pinia';
import { createApp, h } from 'vue';
import type { Component } from 'vue';
import '@svar-ui/vue-grid/all.css';

import AppDatePicker from '@/components/AppDatePicker.vue';
import ConfirmationDialog from '@/components/ConfirmationDialog.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import MainLayouts from '@/Layouts/MainLayouts.vue';
import vuetify from '@/vuetify';
import { ZiggyVue } from 'ziggy-js';
import ErrorLayout from '/resources/js/Layouts/ErrorLayout.vue';

ModuleRegistry.registerModules([AllCommunityModule]);
const appName = import.meta.env.VITE_APP_NAME || 'Jargas';

type ComponentWithLayout = Component & {
    layout?: Component;
};

void createInertiaApp({
    layout: (name, page: ComponentWithLayout) => {
        // Gunakan ErrorLayout agar Header & UserMenu tetap tampil di halaman error
        if (name.startsWith('Errors/') || name === 'ErrorPage') {
            return ErrorLayout; // <-- Diubah dari [] menjadi ErrorLayout
        }

        if (page.layout) {
            return page.layout;
        }

        if (name.startsWith('Auth/')) {
            return GuestLayout;
        }

        return MainLayouts;
    },

    title: (title) => (title ? `${title} - ${appName}` : appName),
    setup({ el, App, props, plugin }) {
        const pinia = createPinia();
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify)
            .use(ZiggyVue)
            .use(pinia);

        app.component('AppDatePicker', AppDatePicker);
        app.component('ConfirmationDialog', ConfirmationDialog);

        if (typeof window !== 'undefined' && el) {
            app.mount(el);

            const loader = document.getElementById('app-loader');

            if (loader) {
                loader.style.opacity = '0';
                setTimeout(() => loader.remove(), 300);
            }
        }

        return app;
    },
    progress: {
        color: '#4B5563',
    },
});
