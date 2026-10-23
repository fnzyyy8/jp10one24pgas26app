import { defineStore } from 'pinia';
import { ref } from 'vue';

export interface BreadCrumbItem {
    title: string;
    disabled?: boolean;
    href?: string;
}

const homeBreadcrumb: BreadCrumbItem = {
    title: 'DASHBOARD',
    href: '/',
};

export const useBreadcrumbStore = defineStore('breadcrumb', () => {
    const items = ref<BreadCrumbItem[]>([{ ...homeBreadcrumb }]);

    const setBreadcrumbs = (newItems: BreadCrumbItem[]) => {
        items.value = [
            { ...homeBreadcrumb },
            ...newItems.filter((item) => item.title !== homeBreadcrumb.title),
        ];
    };

    const clearBreadcrumbs = () => {
        items.value = [{ ...homeBreadcrumb }];
    };

    return {
        items,
        setBreadcrumbs,
        clearBreadcrumbs,
    };
});
