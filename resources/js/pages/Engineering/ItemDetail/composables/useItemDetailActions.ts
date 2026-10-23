import { ref } from 'vue';
import type { ItemDetail } from '@/pages/Engineering/ItemDetail/types/item-detail.type';

const isCreateOpen = ref(false);
const isUpdateOpen = ref(false);
const selectedDetailId = ref<ItemDetail | null>(null);
export function useItemDetailActions() {
    const openCreateDialog = () => {
        isCreateOpen.value = true;
    };

    const openUpdateDialog = (item: ItemDetail) => {
        selectedDetailId.value = item;
        isUpdateOpen.value = true;
    };

    return {
        isCreateOpen,
        isUpdateOpen,
        openCreateDialog,
        openUpdateDialog,
        selectedDetailId,
    };
}
